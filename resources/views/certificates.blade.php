<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat & Penghargaan — Farrelzzzzzzz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        obsidian: '#030305',
                        panel: '#09090e',
                        borderSubtle: '#1b1b29',
                        neonRed: '#ff1736',
                        neonRedGlow: 'rgba(255, 23, 54, 0.4)',
                    }
                }
            }
        }
    </script>
    <style>
        .glass-card {
            background: rgba(12, 12, 19, 0.85);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.07);
        }
    </style>
</head>
<body class="bg-obsidian text-gray-100 font-sans antialiased selection:bg-neonRed selection:text-white">

    <!-- Navbar -->
    <header class="sticky top-0 z-50 bg-obsidian/90 backdrop-blur-2xl border-b border-borderSubtle">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="/" class="text-xs font-mono uppercase tracking-widest text-white flex items-center space-x-2">
                <i class="fa-solid fa-arrow-left text-neonRed"></i>
                <span>Kembali ke Beranda</span>
            </a>
            <a href="/" class="text-base font-black tracking-widest text-white font-mono">FARRELZZZZZZZ</a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="py-20 max-w-7xl mx-auto px-6">
        <div class="space-y-4 mb-16 text-center max-w-2xl mx-auto">
            <span class="text-xs font-mono uppercase tracking-widest text-neonRed bg-neonRed/10 px-4 py-1.5 rounded-full border border-neonRed/20">Credentials</span>
            <h1 class="text-4xl sm:text-5xl font-black text-white">Sertifikat & Penghargaan</h1>
            <p class="text-gray-400 text-sm font-light">Kumpulan sertifikat keahlian profesional dalam bidang UI/UX, Web Development, dan 3D Art.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($certificates as $cert)
            <div class="glass-card rounded-3xl overflow-hidden border border-borderSubtle group hover:border-neonRed transition duration-500 flex flex-col justify-between shadow-2xl">
                <div>
                    @if($cert->image)
                    <div class="relative overflow-hidden aspect-video">
                        <img src="{{ $cert->image }}" alt="{{ $cert->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    </div>
                    @endif
                    <div class="p-8 space-y-3">
                        <div class="flex items-center justify-between text-xs font-mono text-gray-400">
                            <span class="text-neonRed font-bold">{{ $cert->issuer }}</span>
                            <span>{{ $cert->date }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-white group-hover:text-neonRed transition">{{ $cert->title }}</h3>
                    </div>
                </div>
                @if($cert->credential_url)
                <div class="px-8 pb-8 pt-0">
                    <a href="{{ $cert->credential_url }}" target="_blank" class="w-full bg-obsidian hover:bg-neonRed text-gray-300 hover:text-white py-3 rounded-xl text-xs font-mono font-bold uppercase tracking-wider border border-borderSubtle transition flex items-center justify-center space-x-2">
                        <span>Verifikasi Kredensial</span>
                        <i class="fa-solid fa-external-link text-[10px]"></i>
                    </a>
                </div>
                @endif
            </div>
            @empty
            <div class="col-span-3 text-center py-20 glass-card rounded-3xl border border-borderSubtle">
                <p class="text-gray-400 text-sm font-mono">Belum ada sertifikat yang diunggah.</p>
            </div>
            @endforelse
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-obsidian border-t border-borderSubtle py-12 text-center text-xs font-mono text-gray-500">
        <p>© 2026 FARRELZZZZZZZ. ALL RIGHTS RESERVED.</p>
    </footer>

</body>
</html>
