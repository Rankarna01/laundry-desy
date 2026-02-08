<header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 sticky top-0 z-50">
    
    <div class="flex items-center gap-4">
        <button class="md:hidden text-slate-600 hover:text-blue-600 focus:outline-none">
            <i class="fa-solid fa-bars text-xl"></i>
        </button>
        
        <h2 class="text-lg font-semibold text-slate-700 hidden sm:block">
            Sistem Informasi Laundry
        </h2>
    </div>

    <div class="flex items-center gap-4">
        <div class="flex flex-col text-right hidden sm:block">
            {{-- <span class="text-sm font-bold text-slate-700">{{ Auth::user()->name ?? 'Guest' }}</span> --}}
            {{-- <span class="text-xs text-slate-500 capitalize">{{ Auth::user()->role ?? 'Role' }}</span> --}}
            
            <span class="text-sm font-bold text-slate-700">Administrator</span>
            <span class="text-xs text-slate-500">Super Admin</span>
        </div>
        
        <div class="h-10 w-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 border border-slate-300 shadow-sm">
            <i class="fa-solid fa-user"></i>
        </div>
    </div>
</header>