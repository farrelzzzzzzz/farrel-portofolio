<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — Farrel Balapradhana</title>
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
<body class="bg-darkBg text-gray-100 font-sans antialiased">

    <!-- Top Navigation -->
    <nav class="bg-cardBg border-b border-cardBorder px-6 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <a href="/admin/dashboard" class="text-xl font-black tracking-wider text-white">FARREL<span class="text-accentRed">.</span> <span class="text-xs text-gray-400 font-normal">ADMIN</span></a>
        </div>
        <div class="flex items-center space-x-4">
            <a href="/" target="_blank" class="text-xs text-gray-300 hover:text-white transition">Lihat Portfolio →</a>
            <form action="/admin/logout" method="POST">
                @csrf
                <button type="submit" class="text-xs bg-red-500/10 text-red-500 border border-red-500/20 px-3 py-1.5 rounded-lg hover:bg-red-500 hover:text-white transition font-medium">Logout</button>
            </form>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

</body>
</html>
