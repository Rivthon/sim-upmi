<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak | SIM UPMI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Custom Font Definitions */
        @layer base {
            body {
                font-family: 'Poppins', sans-serif;
            }
            h1, h2, h3, h4, h5, h6 {
                font-family: 'Montserrat', sans-serif;
            }
        }

        /* Basic animation for the card */
        @keyframes fadeInSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fadeInSlideUp {
            animation: fadeInSlideUp 0.8s ease-out forwards;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center antialiased">
    <div class="max-w-md w-full p-8 bg-white rounded-xl shadow-2xl text-center animate-fadeInSlideUp">
        <div class="mb-6">
            {{-- Optional: Add a logo here --}}
                <img src="https://www.sbh.ac.id/dashboard_assets/assets/img/logo/logo_sbh_panjang.png" alt="Logo STIKes" class="h-10 w-auto">
                         <br>
            <h1 class="text-5xl font-extrabold text-red-600 mb-2">403</h1>
            <h2 class="text-2xl font-bold text-gray-800">Akses Ditolak!</h2>
        </div>
        
        <p class="text-lg text-gray-700 leading-relaxed mb-6">
            Pendaftaran akun baru tidak diizinkan saat ini.
        </p>
        
        <p class="text-md text-gray-600 leading-relaxed mb-8">
            Silakan hubungi <span class="font-semibold text-blue-600">Admin/ICT</span> jika ingin memiliki akun <span class="font-semibold">SIM UPMI</span>.
        </p>

        <a href="/" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-full shadow-md transition duration-300 ease-in-out transform hover:-translate-y-1 hover:scale-105">
            <svg class="w-5 h-5 mr-2 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Beranda
        </a>
    </div>
</body>
</html>