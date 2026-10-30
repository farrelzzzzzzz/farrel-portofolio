<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Sandi — Farrel Admin</title>
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
            <h2 class="text-xl font-bold text-white mt-4">Lupa Sandi?</h2>
            <p class="text-xs text-gray-400 mt-2">Masukkan email akun admin Anda. Kami akan mengirim kode OTP 6 digit ke email Anda.</p>
        </div>

        @if($errors->any())
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-red-500 text-xs text-center font-medium">
            {{ $errors->first() }}
        </div>
        @endif

        @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-xs text-center font-medium">
            {{ session('success') }}
        </div>
        @endif

        <form action="{{ route('admin.forgot.password.send') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Email Akun Admin</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    placeholder="admin@farrel.com"
                    style="background-color: #0b0b0f !important; color: #ffffff !important; border: 1px solid #232330 !important;"
                    class="w-full rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-accentRed transition">
            </div>

            <button type="submit" class="w-full bg-accentRed hover:bg-accentRedHover text-white py-3.5 rounded-xl font-bold shadow-lg shadow-accentRed/30 transition flex items-center justify-center space-x-2">
                <i class="fa-solid fa-paper-plane"></i>
                <span>Kirim Kode OTP</span>
            </button>
        </form>

        <div class="mt-6 text-center space-y-2">
            <a href="{{ route('login') }}" class="block text-xs text-gray-400 hover:text-accentRed transition">← Kembali ke Halaman Login</a>
        </div>
    </div>

</body>
</html>
