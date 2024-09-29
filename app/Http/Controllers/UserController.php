<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
class UserController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }



    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showProfile()
    {
        $user = Auth::user();
        $user_id = Auth::id();

        $transactionCount = transactions::where('user_id', $user_id)->sum('amount');

        $transactionsSalary = transactions::where('user_id', $user_id)
            ->where('category_id', 1)
            ->sum('amount');

        $Income = transactions::where('user_id', $user_id)
            ->whereHas('category', function ($query) {
                $query->where('type', 'income');
            })
            ->sum('amount');

        $Expense = transactions::where('user_id', $user_id)
            ->whereHas('category', function ($query) {
                $query->where('type', 'expense');
            })
            ->sum('amount');
        $monthlyTransactions = transactions::where('user_id', $user_id)
            ->selectRaw('MONTH(transaction_date) as month, YEAR(transaction_date) as year, SUM(amount) as total_amount')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
        $graphData = [];
        foreach ($monthlyTransactions as $transaction) {
            $monthYear = "{$transaction->year}-{$transaction->month}";
            $graphData[$monthYear] = $transaction->total_amount;
        }


        return view('auth.profile', compact('user', 'transactionCount', 'transactionsSalary', 'Income', 'Expense', 'graphData'));
    }

    public function showProfileInHistory()
    {
        $user = Auth::user();
        $user_id = Auth::id();
        $transactionCount = transactions::where('user_id', $user_id)->sum('amount');
        return view('auth.history', compact('user', 'transactionCount'));
    }

    public function dashboard()
    {
        return view('dashboard');
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->file(key: 'image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName;
        } else {
            $imagePath = null;
        }

        $number = rand();
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'image' => $imagePath,
            'monney' => 0,
            'numberBank' => $number
        ]);

        return redirect()->route('out')->with('success', 'Registration successful. Please log in.');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            session()->put('message', $user->name);
            return redirect()->route('profile');
        }

        return Redirect::back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
