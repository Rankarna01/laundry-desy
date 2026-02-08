<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Laundry Desy</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Poppins', 'sans-serif'] },
                    colors: {
                        primary: '#1e293b',
                        secondary: '#f1f5f9',
                        accent: '#3b82f6',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-secondary h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden border-t-4 border-accent">
        <div class="p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-primary mb-2">Laundry Desy</h1>
                <p class="text-sm text-slate-500">Silakan masuk untuk melanjutkan</p>
            </div>

            @if (session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded text-sm">
                    <p class="font-bold">Gagal!</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <form action="{{ route('login.action') }}" method="POST">
                @csrf
                
                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email Address</label>
                    <input type="email" name="email" id="email" required 
                        class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-200 focus:border-accent focus:ring-2 focus:ring-blue-100 outline-none transition-all"
                        placeholder="nama@email.com">
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-2">Password</label>
                    <input type="password" name="password" id="password" required 
                        class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-200 focus:border-accent focus:ring-2 focus:ring-blue-100 outline-none transition-all"
                        placeholder="••••••••">
                </div>

                <button type="submit" class="w-full bg-accent hover:bg-blue-600 text-white font-semibold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                    Masuk Sekarang
                </button>
            </form>
        </div>
        
        <div class="bg-slate-50 py-4 text-center border-t border-slate-100">
            <p class="text-xs text-slate-400">© {{ date('Y') }} Laundry Desy System</p>
        </div>
    </div>

</body>
</html>