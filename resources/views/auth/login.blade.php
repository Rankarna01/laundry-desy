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

    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-[550px]">
        
        <div class="w-full md:w-1/2 bg-slate-800 relative hidden md:block">
            <img src="https://images.unsplash.com/photo-1545173168-9f1947eebb8f?q=80&w=1000&auto=format&fit=crop" 
                 alt="Laundry Background" 
                 class="absolute inset-0 w-full h-full object-cover opacity-60">
            <div class="relative z-10 h-full flex flex-col justify-center items-center text-white p-10 text-center">
                <div class="mb-6 p-4 bg-white/10 rounded-full backdrop-blur-sm animate-bounce">
                    <i class="fa-solid fa-soap text-5xl text-blue-300"></i>
                </div>
                <h2 class="text-3xl font-bold mb-2 tracking-wide">Laundry Desy</h2>
                <p class="text-slate-200 text-sm leading-relaxed">
                    Gabung sekarang untuk kemudahan layanan laundry antar-jemput yang cepat dan bersih.
                </p>
            </div>
        </div>

        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col">
            
            <div class="flex border-b border-slate-200 mb-8">
                <button onclick="switchTab('login')" id="tab-login" class="w-1/2 pb-4 text-center font-bold text-accent border-b-2 border-accent transition-all hover:text-blue-700">
                    LOGIN
                </button>
                <button onclick="switchTab('register')" id="tab-register" class="w-1/2 pb-4 text-center font-bold text-slate-400 border-b-2 border-transparent hover:text-slate-600 transition-all">
                    REGISTER
                </button>
            </div>

            @if (session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-3 mb-4 rounded text-sm flex items-center gap-2">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error') || $errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-3 mb-4 rounded text-sm">
                    <p class="font-bold mb-1"><i class="fa-solid fa-circle-exclamation"></i> Terjadi Kesalahan:</p>
                    <ul class="list-disc list-inside text-xs">
                        {{ session('error') }}
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="form-login" action="{{ route('login.action') }}" method="POST" class="flex-1 flex flex-col justify-center transition-opacity duration-300">
                @csrf
                
                <div class="mb-5">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400"><i class="fa-solid fa-envelope"></i></div>
                        <input type="email" name="email" required class="w-full pl-10 pr-4 py-3 rounded-lg bg-slate-50 border border-slate-200 focus:border-accent focus:ring-2 focus:ring-blue-100 outline-none transition-all placeholder-slate-400" placeholder="nama@email.com">
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400"><i class="fa-solid fa-lock"></i></div>
                        <input type="password" name="password" required class="w-full pl-10 pr-4 py-3 rounded-lg bg-slate-50 border border-slate-200 focus:border-accent focus:ring-2 focus:ring-blue-100 outline-none transition-all placeholder-slate-400" placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="w-full bg-accent hover:bg-accentHover text-white font-bold py-3.5 px-4 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                    Masuk Sekarang
                </button>

                <div class="mt-6 text-center text-xs text-slate-400">
                    <p>Lupa password? Hubungi Admin.</p>
                </div>
            </form>

            <form id="form-register" action="{{ route('register.action') }}" method="POST" class="hidden flex-1 flex flex-col justify-center transition-opacity duration-300">
                @csrf
                <input type="hidden" name="is_register" value="1"> 

                <div class="mb-4">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400"><i class="fa-solid fa-user"></i></div>
                        <input type="text" name="name" required value="{{ old('name') }}" class="w-full pl-10 pr-4 py-3 rounded-lg bg-slate-50 border border-slate-200 focus:border-accent outline-none text-sm" placeholder="Nama Lengkap">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400"><i class="fa-brands fa-whatsapp"></i></div>
                        <input type="number" name="no_hp" required value="{{ old('no_hp') }}" class="w-full pl-10 pr-4 py-3 rounded-lg bg-slate-50 border border-slate-200 focus:border-accent outline-none text-sm" placeholder="No. HP / WA">
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400"><i class="fa-solid fa-envelope"></i></div>
                        <input type="email" name="email" required value="{{ old('email') }}" class="w-full pl-10 pr-4 py-3 rounded-lg bg-slate-50 border border-slate-200 focus:border-accent outline-none text-sm" placeholder="Email">
                    </div>
                </div>

                <div class="mb-6">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400"><i class="fa-solid fa-lock"></i></div>
                        <input type="password" name="password" required class="w-full pl-10 pr-4 py-3 rounded-lg bg-slate-50 border border-slate-200 focus:border-accent outline-none text-sm" placeholder="Password Baru">
                    </div>
                    <p class="text-xs text-slate-400 mt-1 ml-1">*Minimal 6 karakter</p>
                </div>

                <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-bold py-3.5 px-4 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                    Daftar Jadi Member
                </button>
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
                // Style Button
                btnLogin.classList.add('text-accent', 'border-accent');
                btnLogin.classList.remove('text-slate-400', 'border-transparent');
                
                btnRegister.classList.add('text-slate-400', 'border-transparent');
                btnRegister.classList.remove('text-accent', 'border-accent');

                // Toggle Form
                formLogin.classList.remove('hidden');
                formRegister.classList.add('hidden');
            } else {
                // Style Button
                btnRegister.classList.add('text-accent', 'border-accent');
                btnRegister.classList.remove('text-slate-400', 'border-transparent');

                btnLogin.classList.add('text-slate-400', 'border-transparent');
                btnLogin.classList.remove('text-accent', 'border-accent');

                // Toggle Form
                formRegister.classList.remove('hidden');
                formLogin.classList.add('hidden');
            }
        }

        // Cek jika ada error dari old input (misal validasi gagal saat register), 
        // otomatis buka tab register
        @if(old('is_register'))
            switchTab('register');
        @endif
    </script>

</body>
</html>