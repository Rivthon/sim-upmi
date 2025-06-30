<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'HRIS STIKes Bogor Husada') }}</title> {{-- Update title --}}

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        {{-- Custom Fonts --}}
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">


        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* Custom Font Definitions */
            @layer base {
                body {
                    font-family: 'Poppins', sans-serif;
                }
                h1, h2, h3, h4, h5, h6 { /* Apply Montserrat to headings */
                    font-family: 'Montserrat', sans-serif;
                }
            }

            /* Basic animation for the card (optional) */
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
    <body class="font-sans text-gray-900 antialiased bg-blue-50"> {{-- Change background color --}}
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-blue-50 to-indigo-100"> {{-- Add gradient background --}}
            <div class="mb-6 mt-12 sm:mt-0"> {{-- Add margin bottom and top for logo area --}}
                <a href="/">
                    {{-- Replace x-application-logo with your image and text --}}
                <img src="https://www.sbh.ac.id/dashboard_assets/assets/img/logo/logo_sbh_panjang.png" alt="Logo STIKes" class="h-10 w-auto">
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-2xl overflow-hidden sm:rounded-xl animate-fadeInSlideUp"> {{-- Increased padding, shadow, and rounded --}}
                {{ $slot }}
            </div>
            
            {{-- Optional: Add a simple footer --}}
            <footer class="mt-8 text-center text-sm text-gray-600">
                &copy; {{ date('Y') }} STIKes Bogor Husada. All rights reserved.
            </footer>
        </div>
    </body>
</html>