<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sandi Baru — Farrel Admin</title>
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
<body class="bg-darkBg text-gray-100 font-sans antialiased flex items-center justify-center min-h-screen">

    <div class="max-w-md w-full mx-4 bg-cardBg border border-cardBorder rounded-3xl p-8 shadow-2xl relative">
        <div class="text-center mb-8">
            <a href="/" class="text-2xl font-black tracking-wider text-white">FARREL<span class="text-accentRed">.</span></a>
            <h2 class="text-xl font-bold text-white mt-4">Atur Sandi Baru</h2>
            <p class="text-xs text-gray-400 mt-2">Email <strong class="text-white">{{ session('reset_email') }}</strong> terverifikasi. Silakan masukkan sandi baru Anda.</p>
        </div>

        @if($errors->any())
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-red-500 text-xs text-center font-medium">
            {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('admin.forgot.password.reset') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Sandi Baru</label>
                <input type="password" name="password" required autofocus
                    placeholder="Minimal 8 karakter"
                    style="background-color: #0b0b0f !important; color: #ffffff !important; border: 1px solid #232330 !important;"
                    class="w-full rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-accentRed transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Konfirmasi Sandi Baru</label>
                <input type="password" name="password_confirmation" required
                    placeholder="Ulangi sandi baru"
                    style="background-color: #0b0b0f !important; color: #ffffff !important; border: 1px solid #232330 !important;"
                    class="w-full rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-accentRed transition">
            </div>

            <button type="submit" class="w-full bg-accentRed hover:bg-accentRedHover text-white py-3.5 rounded-xl font-bold shadow-lg shadow-accentRed/30 transition flex items-center justify-center space-x-2">
                <i class="fa-solid fa-key"></i>
                <span>Simpan Sandi Baru</span>
            </button>
        </form>
    </div>

</body>
</html>
