<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk / Daftar - Laundry Desy</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
                        accentHover: '#2563eb'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-secondary min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-[600px]">
        
        <div class="w-full md:w-1/2 bg-slate-800 relative hidden md:block">
            <img src="https://images.unsplash.com/photo-1545173168-9f1947eebb8f?q=80&w=1000&auto=format&fit=crop" 
                 alt="Laundry" class="absolute inset-0 w-full h-full object-cover opacity-60">
            <div class="relative z-10 h-full flex flex-col justify-center items-center text-white p-10 text-center">
                <div class="mb-6 p-4 bg-white/10 rounded-full backdrop-blur-sm">
                    <i class="fa-solid fa-soap text-5xl text-blue-300"></i>
                </div>
                <h2 class="text-3xl font-bold mb-2">Laundry Desy</h2>
                <p class="text-slate-200 text-sm">Login sistem menggunakan Username & Password.</p>
            </div>
        </div>

        <div class="w-full md:w-1/2 p-8 flex flex-col">
            
            <div class="flex border-b border-slate-200 mb-6">
                <button onclick="switchTab('login')" id="tab-login" class="w-1/2 pb-4 font-bold text-accent border-b-2 border-accent transition-all">LOGIN</button>
                <button onclick="switchTab('register')" id="tab-register" class="w-1/2 pb-4 font-bold text-slate-400 border-b-2 border-transparent transition-all">REGISTER</button>
            </div>

            @if (session('success'))
                <div class="bg-green-50 text-green-700 p-3 mb-4 rounded text-sm flex gap-2 border-l-4 border-green-500">
                    <i class="fa-solid fa-check mt-1"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error') || $errors->any())
                <div class="bg-red-50 text-red-700 p-3 mb-4 rounded text-sm border-l-4 border-red-500">
                    <p class="font-bold">Error:</p>
                    <ul class="list-disc list-inside text-xs">
                        {{ session('error') }}
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form id="form-login" action="{{ route('login.action') }}" method="POST" class="flex-1 flex flex-col justify-center">
                @csrf
                
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400"><i class="fa-solid fa-user"></i></div>
                        <input type="text" name="username" required class="w-full pl-10 pr-4 py-3 rounded-lg bg-slate-50 border border-slate-200 focus:border-accent outline-none" placeholder="Masukkan username">
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400"><i class="fa-solid fa-lock"></i></div>
                        <input type="password" name="password" required class="w-full pl-10 pr-4 py-3 rounded-lg bg-slate-50 border border-slate-200 focus:border-accent outline-none" placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="w-full bg-accent hover:bg-accentHover text-white font-bold py-3.5 px-4 rounded-lg shadow-md transition-all">Masuk</button>
            </form>

            <form id="form-register" action="{{ route('register.action') }}" method="POST" class="hidden flex-1 flex flex-col gap-3">
                @csrf
                <input type="hidden" name="is_register" value="1">

                <div class="grid grid-cols-2 gap-3">
                    <input type="text" name="name" required value="{{ old('name') }}" class="w-full px-4 py-2 rounded-lg bg-slate-50 border focus:border-accent outline-none text-sm" placeholder="Nama Lengkap">
                    <input type="text" name="username" required value="{{ old('username') }}" class="w-full px-4 py-2 rounded-lg bg-slate-50 border focus:border-accent outline-none text-sm" placeholder="Username (Tanpa Spasi)">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <input type="email" name="email" required value="{{ old('email') }}" class="w-full px-4 py-2 rounded-lg bg-slate-50 border focus:border-accent outline-none text-sm" placeholder="Email">
                    <input type="number" name="no_hp" required value="{{ old('no_hp') }}" class="w-full px-4 py-2 rounded-lg bg-slate-50 border focus:border-accent outline-none text-sm" placeholder="No. Telepon">
                </div>

                <textarea name="alamat" rows="2" required class="w-full px-4 py-2 rounded-lg bg-slate-50 border focus:border-accent outline-none text-sm" placeholder="Alamat Lengkap">{{ old('alamat') }}</textarea>

                <div class="grid grid-cols-2 gap-3">
                    <input type="password" name="password" required class="w-full px-4 py-2 rounded-lg bg-slate-50 border focus:border-accent outline-none text-sm" placeholder="Password">
                    <input type="password" name="password_confirmation" required class="w-full px-4 py-2 rounded-lg bg-slate-50 border focus:border-accent outline-none text-sm" placeholder="Ulangi Password">
                </div>

                <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-bold py-3 px-4 rounded-lg shadow-md mt-2 transition-all">Daftar Akun</button>
            </form>

        </div>
    </div>

    <script>
        function switchTab(tab) {
            const btnLogin = document.getElementById('tab-login');
            const btnRegister = document.getElementById('tab-register');
            const formLogin = document.getElementById('form-login');
            const formRegister = document.getElementById('form-register');

            if (tab === 'login') {
                btnLogin.className = "w-1/2 pb-4 font-bold text-accent border-b-2 border-accent transition-all";
                btnRegister.className = "w-1/2 pb-4 font-bold text-slate-400 border-b-2 border-transparent transition-all";
                formLogin.classList.remove('hidden');
                formRegister.classList.add('hidden');
            } else {
                btnRegister.className = "w-1/2 pb-4 font-bold text-accent border-b-2 border-accent transition-all";
                btnLogin.className = "w-1/2 pb-4 font-bold text-slate-400 border-b-2 border-transparent transition-all";
                formRegister.classList.remove('hidden');
                formLogin.classList.add('hidden');
            }
        }
        @if(old('is_register')) switchTab('register'); @endif
    </script>
</body>
</html>