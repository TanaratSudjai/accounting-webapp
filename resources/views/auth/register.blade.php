<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ลงทะเบียน</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-cover bg-center"
    style="background-image: url('{{ asset('bg2.jpg') }}')">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-sm">
        <h1 class="text-2xl font-bold text-gray-700 text-center mb-4">ลงทะเบียน</h1>

        <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="space-y-2">
                <label for="name" class="block text-gray-600">ชื่อ</label>
                <input type="text" id="name" name="name" required placeholder="กรอกชื่อของคุณ"
                    class="w-full px-4 py-2 border border-pink-300 rounded-md focus:outline-none focus:ring focus:ring-pink-200">
            </div>

            <div class="space-y-2">
                <label for="email" class="block text-gray-600">อีเมล</label>
                <input type="email" id="email" name="email" required placeholder="กรอกอีเมลของคุณ"
                    class="w-full px-4 py-2 border border-pink-300 rounded-md focus:outline-none focus:ring focus:ring-pink-200">
            </div>

            <div class="space-y-2">
                <label for="password" class="block text-gray-600">รหัสผ่าน</label>
                <input type="password" id="password" name="password" required placeholder="สร้างรหัสผ่านของคุณ"
                    class="w-full px-4 py-2 border border-pink-300 rounded-md focus:outline-none focus:ring focus:ring-pink-200">
            </div>

            <div class="space-y-2">
                <label for="profile_image" class="block text-gray-600">โปรไฟล์ลูกค้า</label>
                <div class="flex items-center justify-center w-full">
                    <label
                        class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-pink-300 rounded-lg cursor-pointer bg-pink-50 hover:bg-pink-100">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg aria-hidden="true" class="w-10 h-10 mb-3 text-pink-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16l-4-4m0 0l4-4m-4 4h18m-8 4l4-4m0 0l-4-4m4 4H3"></path>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">คลิกเพื่ออัปโหลด</span>
                                หรือ ลากไฟล์มาที่นี่</p>
                            <p class="text-xs text-gray-500">PNG, JPG หรือ GIF (ขนาดไม่เกิน 2MB)</p>
                        </div>
                        <input type="file" name="image" id="image" class="hidden" />
                    </label>
                </div>
            </div>

            <button type="submit"
                class="w-full bg-pink-300 text-white py-2 rounded-md hover:bg-pink-400 transition duration-300">
                ลงทะเบียน
            </button>
        </form>

        <p class="text-center text-gray-600 mt-4">มีบัญชีอยู่แล้ว? <a href="{{ route('out') }}"
                class="text-pink-500 hover:underline">เข้าสู่ระบบ</a></p>
    </div>

</body>

</html>
