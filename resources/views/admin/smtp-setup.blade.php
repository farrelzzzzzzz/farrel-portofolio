<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup SMTP Gmail — Farrel Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        darkBg: '#0b0b0f',
                        cardBg: '#13131a',
                        cardBorder: '#232330',
                        accentRed: '#e50914',
                        accentRedHover: '#f40612',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-darkBg text-gray-100 font-sans antialiased flex items-center justify-center min-h-screen p-4">

    <div class="max-w-2xl w-full bg-cardBg border border-cardBorder rounded-3xl p-8 shadow-2xl">
        <div class="text-center mb-6">
            <a href="/admin/dashboard" class="text-2xl font-black tracking-wider text-white">FARREL<span class="text-accentRed">.</span></a>
            <h2 class="text-xl font-bold text-white mt-4">Setup Email SMTP (Gmail)</h2>
            <p class="text-xs text-gray-400 mt-2">Konfigurasi agar email OTP benar-benar terkirim ke Gmail Anda.</p>
        </div>

        @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-xl text-emerald-400 text-sm">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-xl text-red-400 text-sm">
            <i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}
        </div>
        @endif

        <!-- Step-by-step Guide -->
        <div class="bg-darkBg border border-cardBorder rounded-2xl p-5 mb-6 text-xs space-y-3">
            <p class="font-bold text-white text-sm flex items-center space-x-2">
                <i class="fa-solid fa-circle-info text-indigo-400"></i>
                <span>Cara Mendapatkan Google App Password (Wajib untuk Gmail SMTP)</span>
            </p>
            <ol class="list-decimal pl-5 space-y-1.5 text-gray-300">
                <li>Buka <a href="https://myaccount.google.com/security" target="_blank" class="text-accentRed underline">myaccount.google.com/security</a></li>
                <li>Aktifkan <strong class="text-white">2-Step Verification</strong> (Verifikasi 2 Langkah) — wajib!</li>
                <li>Setelah aktif, buka <a href="https://myaccount.google.com/apppasswords" target="_blank" class="text-accentRed underline">myaccount.google.com/apppasswords</a></li>
                <li>Pilih App: <strong class="text-white">Mail</strong> & Device: <strong class="text-white">Other (Custom name)</strong> → ketik "Laravel Farrel"</li>
                <li>Klik Generate. Akan muncul password 16 karakter (contoh: <code class="text-emerald-400">abcd efgh ijkl mnop</code>) — <strong class="text-accentRed">SIMPAN</strong> password ini karena hanya tampil sekali!</li>
            </ol>
        </div>

        <form action="{{ route('admin.smtp.update') }}" method="POST" class="space-y-5">
            @csrf

            <div class="space-y-2">
                <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider">Alamat Gmail Pengirim</label>
                <input type="email" name="mail_username" value="{{ $config['mail_username'] ?? '' }}" required
                    placeholder="farrelbalapradhana@gmail.com"
                    style="background-color: #0b0b0f !important; color: #ffffff !important; border: 1px solid #232330 !important;"
                    class="w-full rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-accentRed transition font-mono">
                <p class="text-[10px] text-gray-500">Gmail yang Anda gunakan untuk mengirim email OTP.</p>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider">Google App Password (16 Karakter)</label>
                <input type="password" name="mail_password" value="{{ $config['mail_password'] ?? '' }}" required
                    placeholder="abcd efgh ijkl mnop"
                    style="background-color: #0b0b0f !important; color: #ffffff !important; border: 1px solid #232330 !important;"
                    class="w-full rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-accentRed transition font-mono">
                <p class="text-[10px] text-gray-500">App Password 16 karakter dari Google (bukan password Gmail Anda).</p>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider">Nama Pengirim (Opsional)</label>
                <input type="text" name="mail_from_name" value="{{ $config['mail_from_name'] ?? 'Farrel Admin' }}"
                    placeholder="Farrel Admin"
                    style="background-color: #0b0b0f !important; color: #ffffff !important; border: 1px solid #232330 !important;"
                    class="w-full rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-accentRed transition">
            </div>

            <div class="flex items-center space-x-2 bg-yellow-500/10 border border-yellow-500/30 rounded-xl p-3 text-xs text-yellow-300">
                <i class="fa-solid fa-triangle-exclamation text-yellow-400"></i>
                <span>Saat ini mode: <code class="font-mono text-white">{{ $config['mail_mailer'] ?? 'log' }}</code>. Setelah disimpan akan berubah ke <code class="font-mono text-emerald-400">smtp</code>.</span>
            </div>

            <div class="flex items-center justify-between pt-2">
                <a href="{{ route('admin.dashboard') }}" class="text-xs text-gray-400 hover:text-accentRed transition">← Kembali ke Dashboard</a>
                <button type="submit" class="bg-accentRed hover:bg-accentRedHover text-white px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-wider shadow-lg shadow-accentRed/30 transition flex items-center space-x-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan & Aktifkan SMTP</span>
                </button>
            </div>
        </form>
    </div>

</body>
</html>
