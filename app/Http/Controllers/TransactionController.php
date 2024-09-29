<?php

namespace App\Http\Controllers;
use App\Models\User;
use Date;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\categories;
use Illuminate\Http\Request;
use App\Models\transactions;
use Lang;

use Spatie\FlareClient\Http\Exceptions\NotFound;
class TransactionController extends Controller
{
    public function showFormTransaction()
    {
        $categories = categories::whereIn('id', [1, 2, 3])->get();
        return view('transactions.create', compact('categories'));
    }

    public function transferMoney(Request $request)
    {
        try {
            // Validate input
            $validatedData = $request->validate([
                'amount' => 'required|numeric|min:1', // ตรวจสอบให้ยอดเงินมากกว่าหรือเท่ากับ 1
                'number' => 'required|string', // ต้องมีหมายเลขบัญชี
            ]);

            // ตรวจสอบผู้ใช้ปลายทาง
            $recipient = User::where('numberBank', $validatedData['number'])->first();
            $userID = Auth::id();

            if (!$recipient) {
                return response()->json(['error' => 'หมายเลขบัญชีปลายทางไม่ถูกต้อง'], 404);
            }

            // ตรวจสอบยอดเงินของผู้โอน
            $sender = User::findOrFail($userID);

            if ($sender->monney < $validatedData['amount']) {
                return response()->json(['error' => 'ยอดเงินไม่เพียงพอ'], 400);
            }

            // เริ่ม transaction
            DB::beginTransaction();

            // ทำการโอนเงิน
            $sender->monney -= $validatedData['amount'];
            $recipient->monney += $validatedData['amount'];

            // บันทึกการทำธุรกรรมสำหรับผู้รับ
            transactions::create([
                'user_id' => $recipient->id, // ใช้ ID ของผู้รับ
                'category_id' => 5,
                'amount' => $validatedData['amount'],
                'description' => 'ได้รับเงินโอนจาก ' . $sender->name,
                'transaction_date' => now(), // ใช้เวลาปัจจุบัน
            ]);

            // บันทึกการทำธุรกรรมสำหรับผู้โอน
            transactions::create([
                'user_id' => $userID,
                'category_id' => 4,
                'amount' => $validatedData['amount'],
                'description' => 'โอนเงินให้หมายเลข ' . $validatedData['number'],
                'transaction_date' => now(), // ใช้เวลาปัจจุบัน
            ]);

            // อัพเดตยอดเงินในฐานข้อมูล
            $sender->save();
            $recipient->save();

            // ยืนยันการทำ transaction
            DB::commit();

            return response()->json(['success' => 'ทำรายการเรียบร้อยเเล้ว'], 200);

        } catch (\Exception $e) {
            // ยกเลิก transaction หากเกิดข้อผิดพลาด
            DB::rollBack();
            // ส่งข้อความแสดงข้อผิดพลาด
            return response()->json(['error' => 'เกิดข้อผิดพลาดในการทำรายการ: ' . $e->getMessage()], 500);
        }
    }




    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date',
        ]);

        $userID = Auth::id();

        // ดึงข้อมูลของหมวดหมู่ที่เลือก
        $category = categories::findOrFail($validatedData['category_id']);

        // ดึงข้อมูลผู้ใช้เพื่ออัปเดตเงิน
        $user = User::findOrFail($userID);

        // ตรวจสอบประเภทหมวดหมู่และอัปเดตข้อมูลเงิน
        if ($category->type === 'income') {
            // กรณีรายรับ เพิ่มเงิน
            transactions::create([
                'user_id' => $userID,
                'category_id' => $validatedData['category_id'],
                'amount' => $validatedData['amount'],
                'description' => $validatedData['description'],
                'transaction_date' => $validatedData['transaction_date'],
            ]);

            $user->monney += $validatedData['amount'];
        } elseif ($category->type === 'expense') {
            // กรณีรายจ่าย ตรวจสอบว่าเงินพอหรือไม่
            if ($user->monney < $validatedData['amount']) {
                return redirect()->back()->withErrors('เงินไม่เพียงพอสำหรับการทำธุรกรรมนี้');
            }

            // ถ้าเงินพอ หักเงิน
            transactions::create([
                'user_id' => $userID,
                'category_id' => $validatedData['category_id'],
                'amount' => $validatedData['amount'],
                'description' => $validatedData['description'],
                'transaction_date' => $validatedData['transaction_date'],
            ]);

            $user->monney -= $validatedData['amount'];
        } else {
            return redirect()->back()->withErrors('ประเภทหมวดหมู่ไม่ถูกต้อง');
        }

        // บันทึกการเปลี่ยนแปลงในข้อมูลเงินของผู้ใช้
        $user->save();

        return redirect()->route('profile')->with('success', 'Transaction record created successfully.');
    }



    public function update(Request $request, $id)
    {
        $transaction = transactions::where('id', $id)->where('user_id', auth()->id())->first();
        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $transaction->update($request->all());

        return response()->json(['transaction' => $transaction, 'message' => 'Transaction updated successfully!']);
    }

    public function destroy($id)
    {
        $transaction = transactions::where('id', $id)->where('user_id', auth()->id())->first();
        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $transaction->delete();
        return response()->json(['message' => 'Transaction deleted successfully!']);
    }

    public function monthlyReport($month, $year)
    {
        $income = auth()->user()->transactions()
            ->whereHas('category', function ($query) {
                $query->where('type', 'income');
            })
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->sum('amount');

        $expenses = auth()->user()->transactions()
            ->whereHas('category', function ($query) {
                $query->where('type', 'expense');
            })
            ->whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->sum('amount');

        return response()->json([
            'income' => $income,
            'expenses' => $expenses,
            'balance' => $income - $expenses,
        ]);
    }

    public function showHistory()
    {
        $user_id = Auth::id();
        $user = User::findOrFail($user_id);
        $transactions = transactions::where('user_id', $user_id)->orderByDesc(column: 'id')->get();
        return view('auth.history', compact('transactions', 'user'));
    }

}
