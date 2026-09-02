<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Farrel Balapradhana</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            <h2 class="text-xl font-bold text-white mt-4">Admin Dashboard Login</h2>
            <p class="text-xs text-gray-400 mt-1">Gunakan email: admin@farrel.com | password: password</p>
        </div>

        @if($errors->any())
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-red-500 text-xs text-center font-medium">
            {{ $errors->first() }}
        </div>
        @endif

        <form action="/admin/login" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Email</label>
                <input type="email" name="email" value="admin@farrel.com" required class="w-full bg-darkBg border border-cardBorder rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-accentRed transition">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Password</label>
                <input type="password" name="password" value="password" required class="w-full bg-darkBg border border-cardBorder rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-accentRed transition">
            </div>
            <button type="submit" class="w-full bg-accentRed hover:bg-accentRedHover text-white py-3.5 rounded-xl font-bold shadow-lg shadow-accentRed/30 transition">
                Masuk Dashboard
            </button>
        </form>
        <div class="mt-6 text-center">
            <a href="/" class="text-xs text-gray-400 hover:text-accentRed transition">← Kembali ke Beranda</a>
        </div>
    </div>

</body>
</html>
