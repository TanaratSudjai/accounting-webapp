<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มรายการธุรกรรมใหม่</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="flex items-center justify-center min-h-screen bg-cover bg-center"
    style="background-image: url('{{ asset('bg2.jpg') }}')">
    @extends('layouts.menu')

    @section('content')
        <div class="container mx-auto p-4 w-full h-screen flex justify-center items-center">
            <div class="rounded-lg shadow-lg p-4 w-full max-w-sm mb-12">
                <h1 class="text-2xl text-pink-600 text-center mb-6 p-4 rounded-2xl"
                    style="background: rgba(255, 255, 255, 0.616)">เพิ่มรายการธุรกรรมใหม่</h1>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('transactions.store') }}" method="POST">
                    @csrf
                    <label for="category_id" class="block text-gray-700 mb-2 w-[35%] p-2 rounded-xl text-center"
                        style="background: rgba(255, 255, 255, 0.616)">หมวดหมู่
                    </label>

                    <select id="category_id" name="category_id" required
                        class="block w-full px-3 py-1.5 border border-gray-300 rounded-xl focus:outline-none focus:ring focus:ring-pink-500 mb-4"
                        style="background: rgba(255, 255, 255, 0.616)">
                        <option value="">เลือกหมวดหมู่</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>

                    <label for="amount" class="block text-gray-700 mb-2 w-[35%] p-2 rounded-xl text-center"
                        style="background: rgba(255, 255, 255, 0.616)">จำนวนเงิน</label>
                    <input type="number" id="amount" name="amount" required step="0.01" placeholder="0.00"
                        class="block w-full px-3 py-1.5 border border-gray-300 rounded-xl focus:outline-none focus:ring focus:ring-pink-500 mb-4"
                        style="background: rgba(255, 255, 255, 0.616)">

                    <label for="description" class="block text-gray-700 mb-2 w-[35%] p-2 rounded-xl text-center"
                        style="background: rgba(255, 255, 255, 0.616)">คำอธิบาย</label>
                    <textarea id="description" name="description" placeholder="รายละเอียดธุรกรรม"
                        class="block w-full px-3 py-1.5 border border-gray-300 rounded-xl focus:outline-none focus:ring focus:ring-pink-500 mb-4"
                        rows="3" style="background: rgba(255, 255, 255, 0.616)"></textarea>

                    <label for="transaction_date" class="block text-gray-700 mb-2 w-[35%] p-2 rounded-xl text-center"
                        style="background: rgba(255, 255, 255, 0.616)">วันที่ทำรายการ</label>
                    <input type="date" id="transaction_date" name="transaction_date" required
                        class="block w-full px-3 py-1.5 border border-gray-300 rounded-xl focus:outline-none focus:ring focus:ring-pink-500 mb-4"
                        style="background: rgba(255, 255, 255, 0.616)">

                    <button type="submit"
                        class="bg-pink-600 text-white font-bold py-2 rounded-lg w-full hover:bg-pink-500 transition duration-300">เพิ่มรายการ</button>
                </form>
            </div>
        </div>
    @endsection
</body>

</html>
