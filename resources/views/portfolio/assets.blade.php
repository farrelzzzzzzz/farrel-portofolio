<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assets Catalog - Farrel Balapradhana</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .glass-card { background: rgba(15, 15, 20, 0.7); backdrop-filter: blur(20px); }
        .bg-obsidian { background-color: #09090b; }
        .text-neonRed { color: #ff2a2a; }
        .bg-neonRed { background-color: #ff2a2a; }
        .border-borderSubtle { border-color: rgba(255, 255, 255, 0.08); }
    </style>
</head>
<body class="bg-obsidian text-white min-h-screen flex flex-col font-sans selection:bg-neonRed selection:text-white">

    <header class="border-b border-borderSubtle sticky top-0 z-50 glass-card">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="/" class="flex items-center space-x-3 text-lg font-black tracking-wider">
                <span class="w-2.5 h-2.5 rounded-full bg-neonRed animate-ping"></span>
                <span>FARREL BALAPRADHANA</span>
            </a>
            <nav class="hidden md:flex items-center space-x-6 text-xs font-mono uppercase tracking-widest text-gray-400">
                <a href="/" class="hover:text-neonRed transition">← Back to Portfolio</a>
            </nav>
        </div>
    </header>

    <main class="flex-grow py-16 px-6 max-w-7xl mx-auto w-full">
        <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <span class="text-xs font-mono uppercase tracking-widest text-neonRed bg-neonRed/10 px-4 py-1.5 rounded-full border border-neonRed/20">Assets Filter: {{ ucfirst($type ?? 'All') }}</span>
                <h1 class="text-4xl font-black text-white mt-4">Catalog & Archives</h1>
                <p class="text-gray-400 text-sm mt-2 font-light">Menampilkan seluruh aset, proyek, dan publikasi berdasarkan filter.</p>
            </div>
            
            <div class="flex flex-wrap gap-2">
                <a href="/assets/all" class="px-5 py-2.5 rounded-xl text-xs font-mono font-bold uppercase transition {{ ($type == 'all' || !$type) ? 'bg-neonRed text-white shadow-lg' : 'glass-card text-gray-300 border border-borderSubtle' }}">All</a>
                <a href="/assets/projects" class="px-5 py-2.5 rounded-xl text-xs font-mono font-bold uppercase transition {{ ($type == 'projects') ? 'bg-neonRed text-white shadow-lg' : 'glass-card text-gray-300 border border-borderSubtle' }}">Projects ({{ $stats['projects'] ?? 0 }})</a>
                <a href="/assets/magazines" class="px-5 py-2.5 rounded-xl text-xs font-mono font-bold uppercase transition {{ ($type == 'magazines') ? 'bg-neonRed text-white shadow-lg' : 'glass-card text-gray-300 border border-borderSubtle' }}">Magazines ({{ $stats['magazines'] ?? 0 }})</a>
                <a href="/assets/certificates" class="px-5 py-2.5 rounded-xl text-xs font-mono font-bold uppercase transition {{ ($type == 'certificates') ? 'bg-neonRed text-white shadow-lg' : 'glass-card text-gray-300 border border-borderSubtle' }}">Certificates ({{ $stats['certificates'] ?? 0 }})</a>
            </div>
        </div>

        @if(isset($projects) && count($projects) > 0 && ($type == 'all' || $type == 'projects'))
        <div class="mb-16">
            <h2 class="text-2xl font-bold mb-6 text-white border-l-4 border-neonRed pl-4">Projects</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($projects as $project)
                <div class="glass-card border border-borderSubtle rounded-3xl overflow-hidden flex flex-col justify-between">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-white">{{ $project->title }}</h3>
                        <p class="text-gray-400 text-sm mt-2">{{ $project->short_description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if(isset($magazines) && count($magazines) > 0 && ($type == 'all' || $type == 'magazines'))
        <div class="mb-16">
            <h2 class="text-2xl font-bold mb-6 text-white border-l-4 border-neonRed pl-4">Magazines</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($magazines as $magazine)
                <div class="glass-card border border-borderSubtle rounded-3xl overflow-hidden flex flex-col justify-between p-6">
                    <h3 class="text-xl font-bold text-white">{{ $magazine->title }}</h3>
                    <p class="text-gray-400 text-sm mt-2 leading-relaxed">{{ $magazine->description }}</p>
                    <a href="{{ route('magazine.show', $magazine->id) }}" class="mt-6 inline-block text-xs font-mono text-neonRed font-bold hover:underline">Open Viewer →</a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if((!isset($projects) || count($projects) == 0) && (!isset($magazines) || count($magazines) == 0))
        <div class="text-center py-24 glass-card border border-borderSubtle rounded-3xl">
            <p class="text-gray-400 font-mono">No assets found for category "{{ $type ?? 'all' }}".</p>
        </div>
        @endif
    </main>

    <footer class="border-t border-borderSubtle py-8 text-center text-xs text-gray-500 font-mono">
        &copy; 2026 Farrel Balapradhana. All rights reserved.
    </footer>
</body>
</html>
