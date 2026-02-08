<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Informasi Laundry Desy')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: '#1e293b',   // Dark Sidebar
                        secondary: '#f1f5f9', // Light Background
                        accent: '#3b82f6',    // Blue Buttons
                        success: '#10b981',   // Green Alerts
                        danger: '#ef4444',    // Red Alerts
                        warning: '#f59e0b',   // Yellow Alerts
                    }
                }
            }
        }
    </script>

    <style>
        /* Custom Scrollbar agar lebih manis */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; 
        }
    </style>
</head>
<body class="bg-secondary text-slate-800 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">
        
        <x-sidebar></x-sidebar> 

        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
            
            <x-navbar></x-navbar>

            <main class="w-full flex-grow p-6">
                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 border-l-4 border-success text-green-700 rounded shadow-sm flex items-center">
                        <i class="fa-solid fa-check-circle mr-2"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-100 border-l-4 border-danger text-red-700 rounded shadow-sm flex items-center">
                        <i class="fa-solid fa-circle-exclamation mr-2"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>

            <footer class="w-full p-4 text-center text-sm text-gray-400">
                &copy; {{ date('Y') }} Laundry Desy. All rights reserved.
            </footer>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @stack('scripts')
</body>
</html>