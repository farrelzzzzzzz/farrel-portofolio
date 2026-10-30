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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <style>
        .glass-card {
            background: rgba(12, 12, 19, 0.85);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.07);
        }
    </style>
</head>
<body class="bg-obsidian text-gray-100 font-sans antialiased selection:bg-neonRed selection:text-white relative overflow-x-hidden">

    <!-- Atmospheric Glow Gradients in Background -->
    <div class="absolute top-0 left-1/4 w-[600px] h-[600px] bg-neonRed/10 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute top-1/3 right-1/4 w-[500px] h-[500px] bg-indigo-600/10 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute bottom-1/4 left-1/3 w-[700px] h-[700px] bg-purple-600/5 rounded-full blur-[160px] pointer-events-none"></div>

    <!-- Navbar -->
    <header class="fixed top-4 left-4 right-4 max-w-7xl mx-auto z-50 bg-obsidian/85 backdrop-blur-3xl border border-borderSubtle rounded-3xl transition-all duration-300 shadow-[0_20px_50px_rgba(0,0,0,0.9)]">
        <div class="px-6 h-20 flex items-center justify-between">
            <a href="/" class="flex items-center space-x-3 group text-xs font-mono uppercase tracking-widest text-white">
                <div class="w-10 h-10 rounded-2xl glass-card flex items-center justify-center border border-neonRed/50 group-hover:border-neonRed transition shadow-lg shadow-neonGlow">
                    <i class="fa-solid fa-arrow-left text-neonRed text-sm"></i>
                </div>
                <span class="hidden sm:inline">Kembali ke Beranda</span>
            </a>
            
            <a href="/" class="flex items-center space-x-2">
                <div class="w-8 h-8 rounded-xl glass-card flex items-center justify-center border border-neonRed/40">
                    <i class="fa-solid fa-cube text-neonRed text-xs"></i>
                </div>
                <span class="text-sm font-black tracking-widest text-white font-mono">FARREL BALAPRADHANA</span>
            </a>

            <div class="flex items-center space-x-2 text-[10px] font-mono text-gray-400 bg-obsidian border border-borderSubtle px-3 py-1.5 rounded-xl">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                <span>CREDENTIALS</span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="pt-36 pb-28 max-w-7xl mx-auto px-6 relative z-10">
        <div class="space-y-4 mb-16 text-center max-w-2xl mx-auto">
            <span class="text-xs font-mono uppercase tracking-widest text-neonRed bg-neonRed/10 px-4 py-1.5 rounded-full border border-neonRed/20 inline-flex items-center space-x-2 shadow-lg shadow-neonGlow">
                <span class="w-2 h-2 rounded-full bg-neonRed animate-ping"></span>
                <span>Credentials Archive</span>
            </span>
            <h1 class="text-4xl sm:text-5xl font-black text-white tracking-tight">Sertifikat & Penghargaan</h1>
            <p class="text-gray-400 text-sm font-light leading-relaxed">Kumpulan sertifikat keahlian profesional resmi dalam bidang UI/UX, Web Development, dan 3D Art yang telah diverifikasi dengan preview PDF interaktif.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($certificates as $cert)
            <div class="glass-card rounded-3xl overflow-hidden border border-borderSubtle group hover:border-neonRed transition duration-500 flex flex-col justify-between shadow-2xl p-6 relative">
                <!-- Absolute glowing accent badge -->
                <div class="absolute -top-12 -right-12 w-28 h-28 bg-neonRed/10 rounded-full blur-2xl group-hover:bg-neonRed/20 transition duration-500 pointer-events-none"></div>

                <div class="space-y-5 relative z-10">
                    <div class="relative overflow-hidden aspect-video bg-obsidian rounded-2xl border border-borderSubtle flex items-center justify-center group-hover:border-neonRed/50 transition shadow-inner">
                        @if($cert->pdf_file || isset($cert->pdf_path))
                        <div class="absolute inset-0 w-full h-full bg-obsidian flex items-center justify-center overflow-hidden cursor-pointer" onclick="window.open('{{ asset('storage/' . ($cert->pdf_file ?? $cert->pdf_path)) }}', '_blank')">
                            <canvas class="cert-pdf-canvas w-full h-full object-contain" data-pdf="{{ asset('storage/' . ($cert->pdf_file ?? $cert->pdf_path)) }}"></canvas>
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center space-x-2 backdrop-blur-xs">
                                <span class="bg-neonRed text-white text-xs font-mono font-bold px-3 py-1.5 rounded-xl shadow-lg">View Full PDF</span>
                            </div>
                        </div>
                        @elseif($cert->image)
                        <img src="{{ $cert->image }}" alt="{{ $cert->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                        @else
                        <div class="absolute inset-0 bg-gradient-to-tr from-obsidian via-panel to-borderSubtle opacity-80"></div>
                        <div class="relative z-10 flex flex-col items-center justify-center space-y-2 text-center p-4">
                            <i class="fa-solid fa-file-pdf text-3xl text-neonRed group-hover:scale-110 transition duration-300"></i>
                            <span class="text-[10px] font-mono text-gray-300 uppercase tracking-widest">PDF Certificate Document</span>
                        </div>
                        @endif
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-xs font-mono text-gray-400">
                            <span class="text-neonRed font-bold uppercase tracking-wider bg-neonRed/10 px-2.5 py-1 rounded-lg border border-neonRed/20">{{ $cert->issuer }}</span>
                            <span class="bg-obsidian px-2.5 py-1 rounded-lg border border-borderSubtle font-mono text-gray-300">{{ $cert->date }}</span>
                        </div>
                        <h3 class="text-lg font-bold text-white group-hover:text-neonRed transition leading-snug">{{ $cert->title }}</h3>
                    </div>
                </div>

                <div class="pt-6 mt-6 border-t border-borderSubtle flex items-center gap-3 relative z-10">
                    @if($cert->pdf_file || isset($cert->pdf_path))
                    <a href="{{ asset('storage/' . ($cert->pdf_file ?? $cert->pdf_path)) }}" target="_blank" class="flex-1 bg-neonRed hover:bg-red-600 text-white py-3 rounded-xl text-xs font-mono font-bold uppercase tracking-wider transition flex items-center justify-center space-x-2 shadow-lg shadow-neonGlow group-hover:scale-[1.02]">
                        <span>Buka PDF</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                    @endif
                    @if($cert->credential_url)
                    <a href="{{ $cert->credential_url }}" target="_blank" class="flex-1 bg-obsidian hover:bg-borderSubtle text-gray-300 hover:text-white py-3 rounded-xl text-xs font-mono font-bold uppercase tracking-wider border border-borderSubtle transition flex items-center justify-center space-x-2">
                        <span>Verifikasi</span>
                        <i class="fa-solid fa-shield-check text-[10px] text-emerald-400"></i>
                    </a>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-20 glass-card rounded-3xl border border-borderSubtle space-y-3">
                <i class="fa-solid fa-certificate text-4xl text-gray-600"></i>
                <p class="text-gray-400 text-sm font-mono">Belum ada sertifikat PDF yang diunggah.</p>
            </div>
            @endforelse
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-obsidian border-t border-borderSubtle py-12 text-center text-xs font-mono text-gray-500">
        <p>© 2026 FARRELZZZZZZZ. ALL RIGHTS RESERVED.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (!window.pdfjsLib) return;
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

            document.querySelectorAll('.cert-pdf-canvas').forEach(async function(canvas) {
                const pdfUrl = canvas.getAttribute('data-pdf');
                if (!pdfUrl) return;
                try {
                    const loadingTask = pdfjsLib.getDocument({
                        url: pdfUrl,
                        cMapUrl: 'https://cdn.jsdelivr.net/npm/pdfjs-dist@3.11.174/cmaps/',
                        cMapPacked: true,
                        withCredentials: false
                    });
                    const pdf = await loadingTask.promise;
                    const page = await pdf.getPage(1);

                    const parent = canvas.parentElement;
                    const targetWidth = parent.clientWidth || 400;
                    const targetHeight = parent.clientHeight || 225;

                    const unscaledViewport = page.getViewport({ scale: 1 });
                    const scaleX = targetWidth / unscaledViewport.width;
                    const scaleY = targetHeight / unscaledViewport.height;
                    const scale = Math.min(scaleX, scaleY);

                    const scaledViewport = page.getViewport({ scale: scale });

                    canvas.width = scaledViewport.width;
                    canvas.height = scaledViewport.height;
                    canvas.style.width = scaledViewport.width + 'px';
                    canvas.style.height = scaledViewport.height + 'px';

                    const context = canvas.getContext('2d');
                    await page.render({ canvasContext: context, viewport: scaledViewport }).promise;
                } catch (err) {
                    console.error('Cert PDF render error:', err);
                }
            });
        });
    </script>

</body>
</html>
