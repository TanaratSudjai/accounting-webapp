<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Profile</title>
    <script src="{{ asset('js/app.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="flex min-h-screen bg-cover bg-center" style="background-image: url('{{ asset('bg2.jpg') }}')">
    @extends('layouts.menu')

    @section('content')
        <div class="container mx-auto p-6">
            <nav class="w-full h-32 bg-cover bg-center rounded-md" style="background-image: url('{{ asset('bg2.jpg') }}');">
                <div class="p-4 text-center w-full flex flex-col justify-center items-center gap-2">
                    <img src="{{ asset($user->image) }}" class="w-16 h-16 border-2 rounded-full">
                    <h2 class="text-xl text-white font-semibold rounded-lg w-auto px-4"
                        style="background-color: rgba(240, 248, 255, 0.342);">{{ $user->name }}
                    </h2>
                </div>
            </nav>
            <div class="bg-pink-100 rounded-xl shadow-md p-6 mb-20 mt-10" style="background: rgba(255, 255, 255, 0.295)">
                <h2 class="text-pink-600 text-2xl font-bold mb-4">รายการธุรกรรม</h2>

                @if ($transactions->isEmpty())
                    <p class="text-gray-600 text-center">ยังไม่มีรายการธุรกรรม</p>
                @else
                    @foreach ($transactions as $transaction)
                        <div class="bg-white rounded-xl shadow-md p-4 mb-4" style="background: rgba(255, 255, 255, 0.616)">
                            <p class="text-pink-600 font-bold text-lg">{{ number_format($transaction->amount, 2) }} ฿</p>
                            <p class="text-gray-700"><strong>หมวดหมู่:</strong> {{ $transaction->category->name }}</p>
                            <p class="text-gray-700"><strong>คำอธิบาย:</strong> {{ $transaction->description }}</p>
                            <p class="text-gray-700"><strong>วันที่:</strong> {{ $transaction->transaction_date }}</p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    @endsection
</body>

</html>
