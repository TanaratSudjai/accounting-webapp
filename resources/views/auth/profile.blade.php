<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>โปรไฟล์ผู้ใช้</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100">
    @extends('layouts.menu')
    <nav class="w-full h-32 bg-cover bg-center rounded-md" style="background-image: url('{{ asset('bg1.jpg') }}');">
        <div class="p-4 text-center w-full flex flex-col justify-center items-center gap-2">
            <img src="{{ asset($user->image) }}" class="w-16 h-16 border-2 rounded-full">
            <h2 class="text-xl text-white font-semibold rounded-lg w-auto px-4"
                style="background-color: rgba(240, 248, 255, 0.342);">{{ $user->name }}
            </h2>
        </div>
    </nav>
    @section('content')
        <div class="container mx-auto p-4 mb-12">
            <div class="bg-white rounded-lg px-3 py-4 shadow-md mt-4"
                style="background-image: url('{{ asset('bg2.jpg') }}');">
                <div class="flex justify-between w-full">
                    <div class="text-lg text-white font-semibold gap-2 px-4 rounded-lg"
                        style="background-color: rgba(240, 248, 255, 0.342);">{{ $user->numberBank }}</div>
                    <div class="flex text-md text-white font-semibold gap-2 px-auto">
                        <h6>ยอดเงิน</h6>
                        <h2 class="text-xl text-white font-semibold rounded-lg w-auto px-8"
                            style="background-color: rgba(240, 248, 255, 0.342);"> {{ $user->monney }}
                        </h2>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-4 shadow-md mt-4 border-l-4 border-pink-500">
                <h2 class="text-xl text-pink-500 font-semibold border-b-2 pb-1">ข้อมูลธุรกรรม</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-2">
                    <div class="flex items-center justify-between text-gray-700">
                        <strong>ยอดเงินธุรกรรมทั้งหมด </strong> <span>{{ $transactionCount }} บาท</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg p-4 shadow-md mt-4 border-l-4 border-pink-500">
                <h2 class="text-xl text-pink-500 font-semibold border-b-2 pb-1">ฟอร์มโอนเงิน</h2>
                <form action="{{ route('transaction.money') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-2">
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700">ยอดเงิน</label>
                            <input type="text" id="amount" name="amount" placeholder="ยอดเงิน"
                                class="mt-1 block w-full border border-gray-300 rounded-md p-1 focus:ring focus:ring-pink-500 focus:border-pink-500"
                                required>
                        </div>
                        <div>
                            <label for="number" class="block text-sm font-medium text-gray-700">หมายเลขบัญชี</label>
                            <input type="text" id="number" name="number" placeholder="หมายเลขบัญชี"
                                class="mt-1 block w-full border border-gray-300 rounded-md p-1 focus:ring focus:ring-pink-500 focus:border-pink-500"
                                required>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit"
                            class="w-full bg-pink-500 text-white py-1 rounded-md hover:bg-pink-600 focus:outline-none focus:ring focus:ring-pink-300">โอนเงิน</button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-lg p-4 shadow-md mt-4 border-l-4 border-pink-500">
                <h2 class="text-xl text-pink-500 font-semibold border-b-2 pb-1">ข้อมูลรายรับและรายจ่าย</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mt-2">
                    <div class="flex items-center justify-between text-gray-700">
                        <strong>รายรับ </strong> <span>{{ number_format($Income, 2) }} บาท</span>
                    </div>
                    <div class="flex items-center justify-between text-gray-700">
                        <strong>รายจ่าย </strong> <span>{{ number_format($Expense, 2) }} บาท</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg p-8 shadow-md mt-4 border-l-4 border-pink-500">
                <canvas id="transactionChart"></canvas>
            </div>
        </div>
        <script>
            const graphData = @json($graphData);
            const labels = Object.keys(graphData);
            const data = Object.values(graphData);

            const ctx = document.getElementById('transactionChart').getContext('2d');
            const transactionChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'ยอดรวมของธุรกรรม',
                        data: data,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'ยอดรวม (฿)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'เดือน-ปี'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'กราฟการใช้จ่าย'
                        }
                    }
                }
            });

            const form = document.querySelector('form');

            form.addEventListener('submit', async function(event) {
                event.preventDefault();

                let formData = new FormData(form);

                try {
                    const response = await fetch(form.action, {
                        method: form.method,
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.error || 'An error occurred');
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'ทำรายการเรียบร้อยแล้ว!',
                        text: 'ได้ทำการโอนเงินสำเร็จเเล้ว',
                        confirmButtonColor: '#FF69B4'
                    });
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาด',
                        text: error.message,
                        confirmButtonColor: '#FF69B4'
                    });
                }
            });
        </script>
    @endsection
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>

</html>
