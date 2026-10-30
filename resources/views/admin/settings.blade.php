@extends('admin.layouts.app')

@section('title', 'Settings — Farrel Admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 sm:space-y-8 pb-16 px-3 sm:px-6 overflow-x-hidden">
    <!-- Admin Quick Navigation Bar -->
    <div class="relative overflow-hidden bg-gradient-to-r from-cardBg via-[#12121a] to-cardBg border border-cardBorder/80 rounded-3xl p-4 sm:p-5 shadow-2xl backdrop-blur-xl">
        <!-- Glow accent background -->
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-accentRed/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <!-- Brand / Title badge -->
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-accentRed to-orange-600 flex items-center justify-center text-white shadow-lg shadow-accentRed/30 shrink-0">
                    <i class="fa-solid fa-gauge-high text-sm"></i>
                </div>
                <div>
                    <span class="text-[10px] uppercase tracking-widest text-gray-400 font-bold block">Farrel Control Center</span>
                    <span class="text-sm font-black text-white tracking-tight">Admin Navigation</span>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="flex items-center space-x-2 overflow-x-auto py-1 no-scrollbar w-full lg:w-auto">
                <a href="{{ route('admin.dashboard') }}" class="group relative inline-flex items-center space-x-2 px-4 py-2.5 {{ request()->routeIs('admin.dashboard') ? 'bg-accentRed text-white shadow-lg shadow-accentRed/30 border border-accentRed' : 'bg-darkBg/90 hover:bg-cardBorder/60 border border-cardBorder/80 text-gray-300 hover:text-white' }} text-xs font-bold rounded-2xl transition-all duration-300 shrink-0">
                    <i class="fa-solid fa-chart-pie {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-accentRed group-hover:scale-110' }} transition-transform"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.magazines.index') }}" class="group relative inline-flex items-center space-x-2 px-4 py-2.5 {{ request()->routeIs('admin.magazines*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30 border border-indigo-500' : 'bg-darkBg/90 hover:bg-cardBorder/60 border border-cardBorder/80 text-gray-300 hover:text-white' }} text-xs font-bold rounded-2xl transition-all duration-300 shrink-0">
                    <i class="fa-solid fa-book-open {{ request()->routeIs('admin.magazines*') ? 'text-white' : 'text-indigo-400 group-hover:scale-110' }} transition-transform"></i>
                    <span>Magazines</span>
                </a>

                <a href="{{ route('admin.settings') }}" class="group relative inline-flex items-center space-x-2 px-4 py-2.5 {{ request()->routeIs('admin.settings') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/30 border border-emerald-500' : 'bg-darkBg/90 hover:bg-cardBorder/60 border border-cardBorder/80 text-gray-300 hover:text-white' }} text-xs font-bold rounded-2xl transition-all duration-300 shrink-0">
                    <i class="fa-solid fa-gear {{ request()->routeIs('admin.settings') ? 'text-white' : 'text-emerald-400 group-hover:rotate-90' }} transition-transform duration-500"></i>
                    <span>Settings</span>
                </a>
            </div>

            <!-- Actions / External View -->
            <div class="flex items-center justify-between lg:justify-end space-x-3 pt-3 lg:pt-0 border-t lg:border-t-0 border-cardBorder/60 shrink-0">
                <div class="hidden sm:flex items-center space-x-2 px-3 py-1.5 bg-darkBg/60 rounded-xl border border-cardBorder/80">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[11px] text-gray-300 font-medium">Session Secure</span>
                </div>

                <a href="{{ url('/') }}" target="_blank" class="group inline-flex items-center space-x-2 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white text-xs font-bold rounded-2xl shadow-lg shadow-blue-600/25 transition-all duration-300 transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-globe text-blue-200 group-hover:rotate-12 transition-transform"></i>
                    <span>Lihat Website</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px] ml-0.5 text-blue-200/70"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-cardBorder pb-6">
        <div class="min-w-0">
            <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight break-words">Pengaturan Admin & Pemulihan</h1>
            <p class="text-xs sm:text-sm text-gray-400 mt-1">Kelola kredensial akun login, nomor WhatsApp pemulihan, dan email pemulihan sandi secara dinamis.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center space-x-2 px-4 py-2 bg-cardBg border border-cardBorder hover:border-accentRed text-white text-xs font-bold rounded-xl transition self-start shrink-0">
            <i class="fa-solid fa-arrow-left text-accentRed"></i>
            <span>Kembali</span>
        </a>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-2xl text-emerald-300 text-sm font-medium flex items-center space-x-3 shadow-lg">
        <i class="fa-solid fa-circle-check text-lg"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="p-4 bg-red-500/10 border border-red-500/30 rounded-2xl text-red-400 text-sm font-medium flex items-center space-x-3 shadow-lg">
        <i class="fa-solid fa-circle-exclamation text-lg"></i>
        <span>{{ $errors->first() }}</span>
    </div>
    @endif

    <!-- FORM 1: RECOVERY CONTACTS (WHATSAPP & EMAIL) -->
    <div class="bg-cardBg border border-cardBorder rounded-2xl sm:rounded-3xl p-4 sm:p-8 space-y-6 shadow-2xl overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center space-y-3 sm:space-y-0 sm:space-x-3 border-b border-cardBorder pb-4">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shrink-0">
                <i class="fa-solid fa-address-book text-base"></i>
            </div>
            <div>
                <h2 class="text-base sm:text-lg font-bold text-white">Kontak Pemulihan Lupa Sandi</h2>
                <p class="text-xs text-gray-400">Nomor WhatsApp dan email yang tampil di menu Lupa Sandi halaman login.</p>
            </div>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider">Nomor WhatsApp Aktif</label>
                    <input type="text" name="admin_whatsapp" value="{{ $settings['admin_whatsapp'] }}" required
                        placeholder="6289666882598"
                        style="background-color: #0b0b0f !important; color: #ffffff !important; border: 1px solid #232330 !important;"
                        class="w-full rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition font-mono">
                    <p class="text-[11px] text-gray-500">Awali 62 (contoh: 6289666882598 atau 08...).</p>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider">Label Tampilan WhatsApp</label>
                    <input type="text" name="admin_whatsapp_label" value="{{ $settings['admin_whatsapp_label'] }}" required
                        placeholder="089666882598"
                        style="background-color: #0b0b0f !important; color: #ffffff !important; border: 1px solid #232330 !important;"
                        class="w-full rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition font-mono">
                    <p class="text-[11px] text-gray-500">Format yang dibaca pengunjung pada tombol.</p>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider">Email Pemulihan</label>
                <input type="email" name="admin_email" value="{{ $settings['admin_email'] }}" required
                    placeholder="admin@farrel.com"
                    style="background-color: #0b0b0f !important; color: #ffffff !important; border: 1px solid #232330 !important;"
                    class="w-full rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition font-mono">
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider">Fonnte API Token (Opsional - untuk kirim OTP via WhatsApp)</label>
                <input type="text" name="fonnte_token" value="{{ $settings['fonnte_token'] }}"
                    placeholder="Kosongkan untuk mode development (OTP tampil di web)"
                    style="background-color: #0b0b0f !important; color: #ffffff !important; border: 1px solid #232330 !important;"
                    class="w-full rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-emerald-500 transition font-mono">
                <p class="text-[10px] text-gray-500">Dapatkan token gratis di <a href="https://fonnte.com" target="_blank" class="text-emerald-400 underline">fonnte.com</a>. Biarkan kosong jika ingin OTP tetap ditampilkan di halaman web.</p>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-wider shadow-lg shadow-emerald-600/30 transition flex items-center space-x-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Kontak Pemulihan</span>
                </button>
            </div>
        </form>
    </div>

    <!-- FORM 2: ADMIN CREDENTIALS (EMAIL & PASSWORD LOGIN) -->
    <div class="bg-cardBg border border-cardBorder rounded-2xl sm:rounded-3xl p-4 sm:p-8 space-y-6 shadow-2xl overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center space-y-3 sm:space-y-0 sm:space-x-3 border-b border-cardBorder pb-4">
            <div class="w-10 h-10 rounded-xl bg-accentRed/10 border border-accentRed/30 flex items-center justify-center text-accentRed shrink-0">
                <i class="fa-solid fa-shield-keyhole text-base"></i>
            </div>
            <div>
                <h2 class="text-base sm:text-lg font-bold text-white">Ganti Akun & Sandi Login Admin</h2>
                <p class="text-xs text-gray-400">Ubah email login utama dan password akun admin Anda di sini.</p>
            </div>
        </div>

        <form action="{{ route('admin.credentials.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-2">
                <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider">Email Login Admin</label>
                <input type="email" name="login_email" value="{{ auth()->user()->email }}" required
                    style="background-color: #0b0b0f !important; color: #ffffff !important; border: 1px solid #232330 !important;"
                    class="w-full rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-accentRed transition font-mono">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider">Password Saat Ini (Wajib jika ubah sandi)</label>
                    <input type="password" name="current_password"
                        placeholder="Masukkan password lama"
                        style="background-color: #0b0b0f !important; color: #ffffff !important; border: 1px solid #232330 !important;"
                        class="w-full rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-accentRed transition">
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider">Password Baru (Minimal 8 Karakter)</label>
                    <input type="password" name="new_password"
                        placeholder="Kosongkan jika tidak diubah"
                        style="background-color: #0b0b0f !important; color: #ffffff !important; border: 1px solid #232330 !important;"
                        class="w-full rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-accentRed transition">
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider">Konfirmasi Password Baru</label>
                <input type="password" name="new_password_confirmation"
                        placeholder="Ulangi password baru"
                        style="background-color: #0b0b0f !important; color: #ffffff !important; border: 1px solid #232330 !important;"
                        class="w-full rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-accentRed transition">
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="bg-accentRed hover:bg-accentRedHover text-white px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-wider shadow-lg shadow-accentRed/30 transition flex items-center space-x-2">
                    <i class="fa-solid fa-key"></i>
                    <span>Simpan Akun & Sandi Baru</span>
                </button>
            </div>
        </form>
    </div>

    <!-- LIVE PREVIEW SECTION -->
    <div class="bg-cardBg border border-cardBorder rounded-2xl sm:rounded-3xl p-4 sm:p-8 space-y-4 shadow-2xl overflow-hidden">
        <h3 class="text-xs sm:text-sm font-bold text-white uppercase tracking-wider flex items-center space-x-2">
            <i class="fa-solid fa-eye text-indigo-400"></i>
            <span>Preview Tampilan Lupa Sandi di Halaman Login</span>
        </h3>
        <div class="bg-darkBg border border-cardBorder rounded-2xl p-4 sm:p-6 max-w-sm mx-auto space-y-3 shadow-inner text-center">
            <p class="text-xs text-gray-400 mb-2">Saat tombol Lupa Sandi? diklik:</p>
            <div class="space-y-2 text-left">
                <div class="flex items-center space-x-3 px-4 py-2.5 text-xs text-gray-300 bg-cardBorder/40 rounded-xl border border-cardBorder">
                    <i class="fa-brands fa-whatsapp text-emerald-400 text-base"></i>
                    <div>
                        <span class="block font-bold text-white">Via WhatsApp</span>
                        <span class="text-[10px] text-gray-400 font-mono">{{ $settings['admin_whatsapp_label'] }}</span>
                    </div>
                </div>
                <div class="flex items-center space-x-3 px-4 py-2.5 text-xs text-gray-300 bg-cardBorder/40 rounded-xl border border-cardBorder">
                    <i class="fa-solid fa-envelope text-accentRed text-base"></i>
                    <div>
                        <span class="block font-bold text-white">Via Email</span>
                        <span class="text-[10px] text-gray-400 font-mono">{{ $settings['admin_email'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
