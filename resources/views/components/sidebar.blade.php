<aside class="w-64 bg-slate-800 text-white flex flex-col transition-all duration-300 shadow-xl hidden md:flex h-full">

    <div class="h-16 flex items-center justify-center border-b border-slate-700 bg-slate-900/50">
        <h1 class="text-xl font-bold tracking-wider flex items-center gap-2">
            <i class="fa-solid fa-soap text-blue-400"></i>
            <span>LAUNDRY DESY</span>
        </h1>
    </div>

    <nav class="flex-1 overflow-y-auto py-4">
        <ul class="space-y-1">

            @if (Auth::user()->role == 'admin')
                <li class="px-4 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wider mt-2">
                    Menu Admin
                </li>

                <li>
                    <a href="{{ url('/dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 transition-colors border-l-4 {{ request()->is('dashboard') ? 'bg-slate-700 text-white border-blue-500' : 'text-slate-300 hover:bg-slate-700 hover:text-white border-transparent hover:border-blue-500' }}">
                        <i
                            class="fa-solid fa-gauge w-5 text-center {{ request()->is('dashboard') ? 'text-blue-400' : '' }}"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('paket.index') }}"
                        class="flex items-center gap-3 px-4 py-3 transition-colors border-l-4 {{ request()->is('paket*') ? 'bg-slate-700 text-white border-blue-500' : 'text-slate-300 hover:bg-slate-700 hover:text-white border-transparent hover:border-blue-500' }}">
                        <i
                            class="fa-solid fa-tags w-5 text-center {{ request()->is('paket*') ? 'text-blue-400' : '' }}"></i>
                        <span>Jenis Paket</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/transaksi') }}"
                        class="flex items-center gap-3 px-4 py-3 transition-colors border-l-4 {{ request()->is('transaksi*') ? 'bg-slate-700 text-white border-blue-500' : 'text-slate-300 hover:bg-slate-700 hover:text-white border-transparent hover:border-blue-500' }}">
                        <i
                            class="fa-solid fa-money-bill-wave w-5 text-center {{ request()->is('transaksi*') ? 'text-blue-400' : '' }}"></i>
                        <span>Transaksi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/pelanggan') }}"
                        class="flex items-center gap-3 px-4 py-3 transition-colors border-l-4 {{ request()->is('pelanggan*') ? 'bg-slate-700 text-white border-blue-500' : 'text-slate-300 hover:bg-slate-700 hover:text-white border-transparent hover:border-blue-500' }}">
                        <i
                            class="fa-solid fa-users w-5 text-center {{ request()->is('pelanggan*') ? 'text-blue-400' : '' }}"></i>
                        <span>Pelanggan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/laporan') }}"
                        class="flex items-center gap-3 px-4 py-3 transition-colors border-l-4 {{ request()->is('laporan*') ? 'bg-slate-700 text-white border-blue-500' : 'text-slate-300 hover:bg-slate-700 hover:text-white border-transparent hover:border-blue-500' }}">
                        <i
                            class="fa-solid fa-file-invoice-dollar w-5 text-center {{ request()->is('laporan*') ? 'text-blue-400' : '' }}"></i>
                        <span>Laporan</span>
                    </a>
                </li>
            @endif


            @if (Auth::user()->role == 'karyawan')
                <li class="px-4 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wider mt-2">
                    Menu Karyawan
                </li>

                <li>
                    <a href="{{ url('/dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 transition-colors border-l-4 {{ request()->is('dashboard') ? 'bg-slate-700 text-white border-blue-500' : 'text-slate-300 hover:bg-slate-700 hover:text-white border-transparent hover:border-blue-500' }}">
                        <i
                            class="fa-solid fa-gauge w-5 text-center {{ request()->is('dashboard') ? 'text-blue-400' : '' }}"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/proses-cucian') }}"
                        class="flex items-center gap-3 px-4 py-3 transition-colors border-l-4 {{ request()->is('proses-cucian*') ? 'bg-slate-700 text-white border-blue-500' : 'text-slate-300 hover:bg-slate-700 hover:text-white border-transparent hover:border-blue-500' }}">
                        <i
                            class="fa-solid fa-shirt w-5 text-center {{ request()->is('proses-cucian*') ? 'text-blue-400' : '' }}"></i>
                        <span>Proses Cucian</span>
                    </a>
                </li>
            @endif


            @if (Auth::user()->role == 'pengguna')
                <li class="px-4 py-2 text-xs font-semibold text-slate-500 uppercase tracking-wider mt-2">
                    Menu Pelanggan
                </li>

                <li>
                    <a href="{{ url('/dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 transition-colors border-l-4 {{ request()->is('dashboard') ? 'bg-slate-700 text-white border-blue-500' : 'text-slate-300 hover:bg-slate-700 hover:text-white border-transparent hover:border-blue-500' }}">
                        <i
                            class="fa-solid fa-gauge w-5 text-center {{ request()->is('dashboard') ? 'text-blue-400' : '' }}"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/pesan-laundry') }}"
                        class="flex items-center gap-3 px-4 py-3 transition-colors border-l-4 {{ request()->is('pesan-laundry*') ? 'bg-slate-700 text-white border-blue-500' : 'text-slate-300 hover:bg-slate-700 hover:text-white border-transparent hover:border-blue-500' }}">
                        <i
                            class="fa-solid fa-cart-shopping w-5 text-center {{ request()->is('pesan-laundry*') ? 'text-blue-400' : '' }}"></i>
                        <span>Pesan Laundry</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/riwayat') }}"
                        class="flex items-center gap-3 px-4 py-3 transition-colors border-l-4 {{ request()->is('riwayat*') ? 'bg-slate-700 text-white border-blue-500' : 'text-slate-300 hover:bg-slate-700 hover:text-white border-transparent hover:border-blue-500' }}">
                        <i
                            class="fa-solid fa-clock-rotate-left w-5 text-center {{ request()->is('riwayat*') ? 'text-blue-400' : '' }}"></i>
                        <span>Riwayat</span>
                    </a>
                </li>
            @endif

        </ul>
    </nav>

    <div class="p-4 border-t border-slate-700 bg-slate-900/30">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white py-2.5 px-4 rounded-lg transition-all shadow-lg hover:shadow-red-900/50 transform hover:-translate-y-0.5">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span class="font-medium">Logout</span>
            </button>
        </form>
    </div>
</aside>
