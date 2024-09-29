<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>เข้าสู่ระบบ</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-cover bg-center"
    style="background-image: url('{{ asset('bg2.jpg') }}')">
    <div class="w-full max-w-sm p-8 bg-pink-100 bg-opacity-90 rounded-2xl shadow-lg">
        <h1 class="text-2xl text-pink-600 font-bold text-center mb-6">เข้าสู่ระบบ</h1>
        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-pink-600 font-medium">อีเมล</label>
                <input type="email" id="email" name="email" required placeholder="กรอกอีเมลของคุณ"
                    class="w-full p-2 border border-pink-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-400 rounded-md">
            </div>
            <div>
                <label for="password" class="block text-pink-600 font-medium">รหัสผ่าน</label>
                <input type="password" id="password" name="password" required placeholder="กรอกรหัสผ่านของคุณ"
                    class="w-full p-2 border border-pink-300 rounded focus:outline-none focus:ring-2 focus:ring-pink-400 rounded-md">
            </div>
            <button type="submit"
                class="w-full bg-pink-400 rounded-md text-white font-semibold py-2 rounded hover:bg-pink-500 transition duration-300">เข้าสู่ระบบ</button>
        </form>
        <p class="text-center text-pink-600 mt-4">ยังไม่มีบัญชี? <a href="{{ route('register') }}"
                class="text-pink-500 underline hover:text-pink-700">สมัครสมาชิก</a></p>
    </div>
    <script src="/js/app.js"></script>
</body>

</html>
