<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farrelzzzzzzz — Executive Creative Developer & 3D Director</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Three.js for Multiple 3D WebGL Canvases -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <!-- GSAP & ScrollTrigger for Smooth Cinematic Page Transitions -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        obsidian: '#030305',
                        panel: '#09090e',
                        panelLighter: '#12121c',
                        borderSubtle: '#1b1b29',
                        neonRed: '#ff1736',
                        neonRedGlow: 'rgba(255, 23, 54, 0.4)',
                    }
                }
            }
        }
    </script>
    <style>
        .book-container { perspective: 2500px; }
        .book-sheet {
            position: absolute;
            width: 50%;
            height: 100%;
            top: 0;
            transform-style: preserve-3d;
            transition: transform 1s cubic-bezier(0.645, 0.045, 0.355, 1);
            transform-origin: left center;
        }
        .book-sheet.flipped { transform: rotateY(-180deg); }
        .book-face {
            position: absolute;
            inset: 0;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }
        .book-face-back { transform: rotateY(180deg); }
        
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #030305; }
        ::-webkit-scrollbar-thumb { background: #1b1b29; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #ff1736; }

        .glass-card {
            background: rgba(12, 12, 19, 0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.07);
        }
        .text-glow {
            text-shadow: 0 0 30px rgba(255, 23, 54, 0.5);
        }

        /* Preloader */
        #preloader {
            position: fixed;
            inset: 0;
            background: #030305;
            z-index: 99998;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity 0.8s ease, visibility 0.8s ease;
        }
    </style>
</head>
<body class="bg-obsidian text-gray-100 font-sans antialiased selection:bg-neonRed selection:text-white overflow-x-hidden">

    <!-- PRELOADER ANIMATION SCREEN -->
    <div id="preloader">
        <div class="relative flex items-center justify-center mb-6">
            <div class="w-20 h-20 rounded-full border-2 border-borderSubtle border-t-neonRed animate-spin"></div>
            <span class="absolute font-mono text-xs text-neonRed font-bold" id="loader-progress">0%</span>
        </div>
        <h2 class="text-xl font-black tracking-widest text-white font-mono">FARRELZZZZZZZ</h2>
        <p class="text-xs font-mono text-gray-500 mt-2 tracking-wider">INITIALIZING 3D WEBGL & ASSETS...</p>
    </div>

    <!-- Executive Responsive Navbar -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-obsidian/90 backdrop-blur-2xl border-b border-borderSubtle transition-all duration-300 shadow-2xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between">
            <a href="#home" class="text-base sm:text-lg font-black tracking-widest text-white flex items-center space-x-2 sm:space-x-3 group">
                <span class="w-2.5 h-2.5 rounded-full bg-neonRed animate-ping"></span>
                <span class="tracking-widest font-mono">FARRELZZZZZZZ</span>
            </a>
            
            <nav class="hidden xl:flex items-center space-x-6 text-[11px] font-mono uppercase tracking-widest text-gray-400">
                <a href="#home" class="hover:text-neonRed transition">01. Overview</a>
                <a href="#3d-showroom" class="hover:text-neonRed transition">02. 3D Hub</a>
                <a href="#editorial-library" class="hover:text-neonRed transition">03. Editorial</a>
                <a href="#portfolio" class="hover:text-neonRed transition">04. Works</a>
                <a href="#experience" class="hover:text-neonRed transition">05. Experience</a>
                <a href="#contact" class="hover:text-neonRed transition">06. Connect</a>
            </nav>

            <div class="flex items-center space-x-3">
                <a href="#contact" class="bg-neonRed hover:bg-red-600 text-white px-4 sm:px-6 py-2.5 rounded-full text-xs font-mono font-bold uppercase tracking-wider shadow-lg shadow-neonGlow transition transform hover:scale-105">
                    Start Project
                </a>
                
                <button onclick="toggleMobileMenu()" class="xl:hidden text-gray-300 hover:text-white p-2 focus:outline-none glass-card rounded-xl border border-borderSubtle">
                    <i class="fa-solid fa-bars text-lg" id="menu-icon"></i>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden xl:hidden bg-obsidian/95 border-b border-borderSubtle px-6 py-6 space-y-4 backdrop-blur-2xl shadow-2xl">
            <a href="#home" onclick="toggleMobileMenu()" class="block text-xs font-mono uppercase tracking-widest text-gray-300 hover:text-neonRed transition py-2">01. Overview</a>
            <a href="#3d-showroom" onclick="toggleMobileMenu()" class="block text-xs font-mono uppercase tracking-widest text-gray-300 hover:text-neonRed transition py-2">02. 3D Hub (Multiple)</a>
            <a href="#editorial-library" onclick="toggleMobileMenu()" class="block text-xs font-mono uppercase tracking-widest text-gray-300 hover:text-neonRed transition py-2">03. Editorial Library</a>
            <a href="#portfolio" onclick="toggleMobileMenu()" class="block text-xs font-mono uppercase tracking-widest text-gray-300 hover:text-neonRed transition py-2">04. Works Archive</a>
            <a href="#experience" onclick="toggleMobileMenu()" class="block text-xs font-mono uppercase tracking-widest text-gray-300 hover:text-neonRed transition py-2">05. Experience</a>
            <a href="#contact" onclick="toggleMobileMenu()" class="block text-xs font-mono uppercase tracking-widest text-gray-300 hover:text-neonRed transition py-2">06. Connect</a>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section id="home" class="relative pt-36 pb-28 min-h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute top-1/4 left-1/4 w-[600px] h-[600px] bg-neonRed/10 rounded-full blur-[180px] pointer-events-none"></div>
        <div class="absolute bottom-1/4 right-1/4 w-[600px] h-[600px] bg-blue-600/10 rounded-full blur-[180px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-6 w-full z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                
                <div class="lg:col-span-7 space-y-8 hero-content">
                    <div class="inline-flex items-center space-x-3 px-4 py-2 glass-card rounded-full text-neonRed text-xs font-mono tracking-widest border border-neonRed/30">
                        <span class="w-2 h-2 rounded-full bg-neonRed animate-pulse"></span>
                        <span>WORLD-CLASS DIGITAL ARCHITECTURE & 3D EXPERIENCES</span>
                    </div>
                    
                    <h1 class="text-5xl sm:text-7xl font-black tracking-tight text-white leading-none">
                        ENGINEERING <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-white via-gray-400 to-neonRed text-glow">THE DIGITAL FUTURE</span>
                    </h1>

                    <p class="text-gray-400 text-base sm:text-lg max-w-xl leading-relaxed font-light">
                        Saya <strong class="text-white font-normal">Farrelzzzzzzz</strong>. Senior Creative Technologist & 3D Art Director yang merancang web berperforma tinggi, interaksi 3D kompleks, dan publikasi digital imersif.
                    </p>

                    <div class="grid grid-cols-3 gap-4 pt-2">
                        <div class="glass-card p-4 rounded-2xl border border-borderSubtle">
                            <div class="text-2xl font-black text-white font-mono">3+</div>
                            <div class="text-[10px] font-mono text-gray-400 uppercase mt-1">Active 3D Engines</div>
                        </div>
                        <div class="glass-card p-4 rounded-2xl border border-borderSubtle">
                            <div class="text-2xl font-black text-white font-mono">2</div>
                            <div class="text-[10px] font-mono text-gray-400 uppercase mt-1">Digital Magazines</div>
                        </div>
                        <div class="glass-card p-4 rounded-2xl border border-borderSubtle">
                            <div class="text-2xl font-black text-white font-mono">100%</div>
                            <div class="text-[10px] font-mono text-gray-400 uppercase mt-1">Precision UI/UX</div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-5 pt-4">
                        <a href="#3d-showroom" class="bg-neonRed hover:bg-red-600 text-white px-8 py-4 rounded-2xl font-mono text-xs uppercase tracking-widest font-bold shadow-2xl shadow-neonGlow transition transform hover:scale-105 flex items-center space-x-3 interactive-item">
                            <span>Explore 3D Hub</span>
                            <i class="fa-solid fa-cube text-sm"></i>
                        </a>
                        <a href="/certificates" class="glass-card hover:bg-borderSubtle text-gray-200 px-8 py-4 rounded-2xl font-mono text-xs uppercase tracking-widest font-bold transition border border-borderSubtle interactive-item flex items-center space-x-2">
                            <i class="fa-solid fa-certificate text-neonRed"></i>
                            <span>Lihat Sertifikat ({{ \App\Models\Certificate::count() }})</span>
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-5 relative flex justify-center hero-3d-wrapper">
                    <div class="relative w-full max-w-md h-[480px] glass-card rounded-3xl p-6 shadow-2xl overflow-hidden group border border-borderSubtle">
                        <div class="absolute top-6 left-6 z-20 bg-obsidian/90 px-4 py-2 rounded-xl border border-borderSubtle text-[10px] font-mono tracking-widest text-neonRed flex items-center space-x-2">
                            <i class="fa-solid fa-atom fa-spin"></i>
                            <span>WEBGL 3D CORE #01</span>
                        </div>
                        
                        <div id="hero-3d-container" class="w-full h-full cursor-grab active:cursor-grabbing"></div>
                        
                        <div class="absolute bottom-6 right-6 z-20 text-[10px] font-mono text-gray-500 bg-obsidian/80 px-3 py-1.5 rounded-lg border border-borderSubtle">
                            [DRAG TO ROTATE]
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- MULTIPLE 3D SHOWROOM HUB -->
    <section id="3d-showroom" class="py-28 bg-panel border-y border-borderSubtle scroll-section">
        <div class="max-w-7xl mx-auto px-6 space-y-16">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <span class="text-xs font-mono uppercase tracking-widest text-neonRed bg-neonRed/10 px-4 py-1.5 rounded-full border border-neonRed/20">3D Interactive Hub</span>
                    <h2 class="text-4xl font-black text-white mt-4">Multiple 3D Showroom Matrix</h2>
                    <p class="text-gray-400 text-sm mt-2 font-light max-w-xl">Koleksi beberapa model 3D real-time berstandar Sketchfab yang dibangun langsung di dalam web browser.</p>
                </div>
                <div class="text-xs font-mono text-gray-400 glass-card px-4 py-2 rounded-xl border border-borderSubtle">
                    <span class="text-neonRed font-bold">3 Active Models</span> Loaded in WebGL
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="glass-card rounded-3xl p-6 border border-borderSubtle flex flex-col justify-between shadow-2xl group hover:border-neonRed transition duration-500">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-mono text-neonRed uppercase font-bold">Model 01 // Hypercar</span>
                            <span class="text-[10px] font-mono text-gray-500 bg-obsidian px-2 py-1 rounded">WebGL</span>
                        </div>
                        <div class="relative w-full h-[280px] bg-obsidian rounded-2xl overflow-hidden border border-borderSubtle" id="car-3d-container"></div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-borderSubtle flex items-center justify-between">
                        <span class="text-xs text-gray-400 font-light">Red Livery & PBR Shaders</span>
                        <button onclick="resetCarCamera()" class="text-xs font-mono text-neonRed hover:underline font-bold">Reset 3D</button>
                    </div>
                </div>

                <div class="glass-card rounded-3xl p-6 border border-borderSubtle flex flex-col justify-between shadow-2xl group hover:border-neonRed transition duration-500">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-mono text-neonRed uppercase font-bold">Model 02 // Mech Drone</span>
                            <span class="text-[10px] font-mono text-gray-500 bg-obsidian px-2 py-1 rounded">WebGL</span>
                        </div>
                        <div class="relative w-full h-[280px] bg-obsidian rounded-2xl overflow-hidden border border-borderSubtle" id="drone-3d-container"></div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-borderSubtle flex items-center justify-between">
                        <span class="text-xs text-gray-400 font-light">Cybernetic Armor & Blades</span>
                        <button onclick="resetDroneCamera()" class="text-xs font-mono text-neonRed hover:underline font-bold">Reset 3D</button>
                    </div>
                </div>

                <div class="glass-card rounded-3xl p-6 border border-borderSubtle flex flex-col justify-between shadow-2xl group hover:border-neonRed transition duration-500">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-mono text-neonRed uppercase font-bold">Model 03 // Quantum Torus</span>
                            <span class="text-[10px] font-mono text-gray-500 bg-obsidian px-2 py-1 rounded">WebGL</span>
                        </div>
                        <div class="relative w-full h-[280px] bg-obsidian rounded-2xl overflow-hidden border border-borderSubtle" id="torus-3d-container"></div>
                    </div>
                    <div class="mt-6 pt-4 border-t border-borderSubtle flex items-center justify-between">
                        <span class="text-xs text-gray-400 font-light">Torus Knot & Wireframe</span>
                        <button onclick="resetTorusCamera()" class="text-xs font-mono text-neonRed hover:underline font-bold">Reset 3D</button>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- FIGMA INTERACTIVE WORKSPACE SECTION -->
    <section id="figma-workspace" class="py-28 bg-panel border-y border-borderSubtle scroll-section">
        <div class="max-w-7xl mx-auto px-6 space-y-12">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <span class="text-xs font-mono uppercase tracking-widest text-indigo-400 bg-indigo-500/10 px-4 py-1.5 rounded-full border border-indigo-500/20">UI/UX Studio</span>
                    <h2 class="text-4xl font-black text-white mt-4">Interactive Figma Workspace</h2>
                    <p class="text-gray-400 text-sm mt-2 font-light max-w-xl">Eksplorasi langsung design system, frames, dan prototype interaktif UI/UX dalam antarmuka ala Figma editor.</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-xs font-mono text-gray-400">Active Mode:</span>
                    <span class="bg-indigo-600/20 text-indigo-400 px-3 py-1 rounded-xl text-xs font-mono font-bold border border-indigo-500/30">Prototype Inspector</span>
                </div>
            </div>

            <!-- Figma Canvas Editor UI Mockup & Embed -->
            <div class="glass-card rounded-3xl border border-borderSubtle shadow-2xl overflow-hidden bg-obsidian">
                <!-- Figma Top Toolbar -->
                <div class="bg-zinc-950 px-6 py-3 border-b border-borderSubtle flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <span class="w-3 h-3 rounded-full bg-red-500 inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-yellow-500 inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-green-500 inline-block"></span>
                        </div>
                        <div class="h-4 w-[1px] bg-borderSubtle"></div>
                        <div class="flex items-center space-x-2 text-xs font-mono text-gray-300">
                            <i class="fa-brands fa-figma text-indigo-400 text-sm"></i>
                            <span class="font-bold text-white">Farrel Balapradhana — UI/UX Master Workspace</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-[10px] font-mono bg-indigo-600/20 text-indigo-400 px-3 py-1 rounded border border-indigo-500/30">Live Sync</span>
                        <a href="https://www.figma.com" target="_blank" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-1.5 rounded-xl text-xs font-mono font-bold transition flex items-center space-x-2">
                            <span>Open in Figma</span>
                            <i class="fa-solid fa-external-link-alt text-[10px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Figma Canvas Body -->
                <div class="grid grid-cols-1 lg:grid-cols-4 min-h-[600px]">
                    <!-- Left Layers Sidebar -->
                    <div class="hidden lg:block bg-zinc-950/60 border-r border-borderSubtle p-4 space-y-4 text-xs font-mono text-gray-400">
                        <div class="text-[10px] uppercase text-gray-500 font-bold tracking-widest px-2">Layers & Frames</div>
                        <div class="space-y-1">
                            <div class="flex items-center space-x-2 px-3 py-2 rounded-xl bg-indigo-600/10 text-indigo-400 border border-indigo-500/25">
                                <i class="fa-solid fa-mobile-screen"></i>
                                <span>📱 Mobile App Prototype</span>
                            </div>
                            <div class="flex items-center space-x-2 px-3 py-2 rounded-xl hover:bg-borderSubtle transition text-gray-300">
                                <i class="fa-solid fa-desktop"></i>
                                <span>💻 Web Dashboard UI</span>
                            </div>
                            <div class="flex items-center space-x-2 px-3 py-2 rounded-xl hover:bg-borderSubtle transition text-gray-300">
                                <i class="fa-solid fa-layer-group"></i>
                                <span>🎨 Design System Tokens</span>
                            </div>
                            <div class="flex items-center space-x-2 px-3 py-2 rounded-xl hover:bg-borderSubtle transition text-gray-300">
                                <i class="fa-solid fa-shapes"></i>
                                <span>🧩 Component Library</span>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-borderSubtle">
                            <div class="text-[10px] uppercase text-gray-500 font-bold tracking-widest px-2 mb-2">Properties</div>
                            <div class="space-y-2 text-[11px] text-gray-300 px-2">
                                <div class="flex justify-between"><span>Fill:</span> <span class="text-indigo-400">#0B0B0F</span></div>
                                <div class="flex justify-between"><span>Auto Layout:</span> <span class="text-green-400">Enabled</span></div>
                                <div class="flex justify-between"><span>Spacing:</span> <span class="text-gray-400">24px</span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Center Main Canvas (Figma Embed / Interactive Prototype) -->
                    <div class="lg:col-span-3 relative bg-darkBg flex flex-col items-center justify-center p-4">
                        @php
                            $featuredProject = $projects->first(fn($p) => !empty($p->figma_url)) ?? $projects->first();
                        @endphp

                        @if($featuredProject && $featuredProject->figma_url)
                        <div class="w-full h-[580px] rounded-2xl overflow-hidden border border-borderSubtle shadow-2xl relative">
                            <iframe 
                                src="https://www.figma.com/embed?embed_host=share&url={{ urlencode($featuredProject->figma_url) }}" 
                                allowfullscreen 
                                class="w-full h-full border-0">
                            </iframe>
                        </div>
                        <div class="mt-4 flex items-center justify-between w-full px-2 text-xs font-mono text-gray-400">
                            <span>Active Frame: <strong class="text-white">{{ $featuredProject->title }}</strong></span>
                            <a href="{{ $featuredProject->figma_url }}" target="_blank" class="text-indigo-400 hover:underline">Buka Fullscreen Prototype →</a>
                        </div>
                        @else
                        <div class="text-center p-12 space-y-4">
                            <i class="fa-brands fa-figma text-5xl text-indigo-500"></i>
                            <p class="text-gray-300 font-mono text-sm">Belum ada link prototype Figma yang ditambahkan.</p>
                            <p class="text-gray-500 text-xs">Tambahkan link Figma melalui <a href="/admin/dashboard" class="text-neonRed underline">Admin Dashboard</a>.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- EDITORIAL LIBRARY -->
    <section id="editorial-library" class="py-28 scroll-section">
        <div class="max-w-7xl mx-auto px-6 space-y-16">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <span class="text-xs font-mono uppercase tracking-widest text-neonRed bg-neonRed/10 px-4 py-1.5 rounded-full border border-neonRed/20">Editorial Library</span>
                    <h2 class="text-4xl font-black text-white mt-4">Multiple Digital Publications</h2>
                    <p class="text-gray-400 text-sm mt-2 font-light max-w-xl">Koleksi majalah digital interaktif dengan efek flipbook fisik 3D.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                
                <!-- Magazine 1 -->
                <div class="glass-card rounded-3xl p-8 border border-borderSubtle shadow-2xl space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-xs font-mono text-neonRed uppercase font-bold">Publication #01</span>
                            <h3 class="text-2xl font-bold text-white mt-1">Cagar Magazine Issue #12</h3>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button onclick="prevPage1()" class="glass-card px-3 py-1.5 rounded-xl text-xs font-mono text-white border border-borderSubtle hover:bg-borderSubtle">Prev</button>
                            <span id="page-indicator-1" class="text-xs font-mono text-gray-400 px-2">Cover</span>
                            <button onclick="nextPage1()" class="bg-neonRed text-white px-3 py-1.5 rounded-xl text-xs font-mono font-bold">Next</button>
                        </div>
                    </div>

                    <div class="relative w-full h-[380px] bg-obsidian border border-borderSubtle rounded-2xl overflow-hidden flex items-center justify-center p-4 cursor-pointer" onclick="nextPage1()">
                        <div class="relative w-full h-full max-w-lg book-container flex items-center justify-center">
                            <div id="m1-sheet-2" class="book-sheet absolute right-0 w-1/2 h-full z-10">
                                <div class="book-face bg-zinc-950 border-r border-borderSubtle p-6 flex flex-col justify-between">
                                    <div>
                                        <span class="text-[10px] font-mono text-neonRed">BACK COVER</span>
                                        <h4 class="text-lg font-bold text-white mt-2">Cagar Publications</h4>
                                    </div>
                                    <span class="text-[10px] font-mono text-gray-600">© 2026</span>
                                </div>
                                <div class="book-face book-face-back bg-zinc-900 border-l border-borderSubtle p-6 flex flex-col justify-between">
                                    <div>
                                        <span class="text-[10px] font-mono text-gray-500">PAGE 02</span>
                                        <h4 class="text-lg font-bold text-white mt-2">Urban Ecology</h4>
                                        <p class="text-gray-300 text-xs mt-2 font-light">Integrasi tanaman vertikal pada fasad gedung tinggi mengurangi suhu kota secara drastis.</p>
                                    </div>
                                    <span class="text-[10px] font-mono text-gray-600">02</span>
                                </div>
                            </div>

                            <div id="m1-sheet-1" class="book-sheet absolute right-0 w-1/2 h-full z-20">
                                <div class="book-face bg-gradient-to-br from-zinc-900 to-black border-r border-borderSubtle p-6 flex flex-col justify-between">
                                    <div>
                                        <span class="text-[10px] font-mono text-neonRed">ISSUE #12</span>
                                        <h4 class="text-xl font-bold text-white mt-2">Architecture & Nature</h4>
                                    </div>
                                    <span class="text-[10px] font-mono text-neonRed font-bold">Click to Open →</span>
                                </div>
                                <div class="book-face book-face-back bg-zinc-900 border-l border-borderSubtle p-6 flex flex-col justify-between">
                                    <div>
                                        <span class="text-[10px] font-mono text-gray-500">PAGE 01</span>
                                        <h4 class="text-lg font-bold text-white mt-2">Editor's Note</h4>
                                        <p class="text-gray-300 text-xs mt-2 font-light">Selamat datang di edisi khusus yang membahas masa depan perancangan kota berkelanjutan.</p>
                                    </div>
                                    <span class="text-[10px] font-mono text-gray-600">01</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Magazine 2 -->
                <div class="glass-card rounded-3xl p-8 border border-borderSubtle shadow-2xl space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-xs font-mono text-neonRed uppercase font-bold">Publication #02</span>
                            <h3 class="text-2xl font-bold text-white mt-1">Apex Design Review Vol. 4</h3>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button onclick="prevPage2()" class="glass-card px-3 py-1.5 rounded-xl text-xs font-mono text-white border border-borderSubtle hover:bg-borderSubtle">Prev</button>
                            <span id="page-indicator-2" class="text-xs font-mono text-gray-400 px-2">Cover</span>
                            <button onclick="nextPage2()" class="bg-neonRed text-white px-3 py-1.5 rounded-xl text-xs font-mono font-bold">Next</button>
                        </div>
                    </div>

                    <div class="relative w-full h-[380px] bg-obsidian border border-borderSubtle rounded-2xl overflow-hidden flex items-center justify-center p-4 cursor-pointer" onclick="nextPage2()">
                        <div class="relative w-full h-full max-w-lg book-container flex items-center justify-center">
                            <div id="m2-sheet-2" class="book-sheet absolute right-0 w-1/2 h-full z-10">
                                <div class="book-face bg-zinc-950 border-r border-borderSubtle p-6 flex flex-col justify-between">
                                    <div>
                                        <span class="text-[10px] font-mono text-neonRed">BACK COVER</span>
                                        <h4 class="text-lg font-bold text-white mt-2">Apex Global</h4>
                                    </div>
                                    <span class="text-[10px] font-mono text-gray-600">© 2026</span>
                                </div>
                                <div class="book-face book-face-back bg-zinc-900 border-l border-borderSubtle p-6 flex flex-col justify-between">
                                    <div>
                                        <span class="text-[10px] font-mono text-gray-500">PAGE 02</span>
                                        <h4 class="text-lg font-bold text-white mt-2">Design Systems</h4>
                                        <p class="text-gray-300 text-xs mt-2 font-light">Skalabilitas komponen UI/UX untuk aplikasi multi-platform perusahaan besar.</p>
                                    </div>
                                    <span class="text-[10px] font-mono text-gray-600">02</span>
                                </div>
                            </div>

                            <div id="m2-sheet-1" class="book-sheet absolute right-0 w-1/2 h-full z-20">
                                <div class="book-face bg-gradient-to-br from-indigo-950 to-black border-r border-borderSubtle p-6 flex flex-col justify-between">
                                    <div>
                                        <span class="text-[10px] font-mono text-indigo-400">VOL. 04</span>
                                        <h4 class="text-xl font-bold text-white mt-2">Future of UI/UX</h4>
                                    </div>
                                    <span class="text-[10px] font-mono text-indigo-400 font-bold">Click to Open →</span>
                                </div>
                                <div class="book-face book-face-back bg-zinc-900 border-l border-borderSubtle p-6 flex flex-col justify-between">
                                    <div>
                                        <span class="text-[10px] font-mono text-gray-500">PAGE 01</span>
                    <h4 class="text-lg font-bold text-white mt-2">Foreword</h4>
                    <p class="text-gray-300 text-xs mt-2 font-light">Eksplorasi mendalam tentang tren antarmuka spatial computing dan WebGL imersif.</p>
                                    </div>
                                    <span class="text-[10px] font-mono text-gray-600">01</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                <div>
                    <span class="text-xs font-mono uppercase tracking-widest text-neonRed bg-neonRed/10 px-4 py-1.5 rounded-full border border-neonRed/20">Archive</span>
                    <h2 class="text-4xl font-black text-white mt-4">Selected Works</h2>
                    <p class="text-gray-400 text-sm mt-2 font-light">Kurasi proyek terbaik dalam bidang UI/UX, 3D, dan pengembangan web.</p>
                </div>
                
                <div class="flex flex-wrap gap-2">
                    @php
                        $filterCats = ['All', 'UI/UX Design', 'Graphic Design', '3D Design', 'Animation', 'Web Development'];
                    @endphp
                    @foreach($filterCats as $fcat)
                    <a href="/?category={{ urlencode($fcat) }}" class="px-5 py-3 rounded-2xl text-xs font-mono font-bold uppercase tracking-wider transition duration-300 {{ ($category === $fcat) ? 'bg-neonRed text-white shadow-xl shadow-neonGlow' : 'glass-card text-gray-300 hover:bg-borderSubtle border border-borderSubtle' }}">
                        {{ $fcat }}
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($projects as $project)
                <div class="glass-card border border-borderSubtle rounded-3xl overflow-hidden group hover:border-neonRed transition duration-500 flex flex-col justify-between shadow-2xl hover:-translate-y-2">
                    <div>
                        <div class="relative overflow-hidden aspect-video">
                            <img src="{{ $project->thumbnail }}" alt="{{ $project->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                            <div class="absolute top-4 left-4 bg-obsidian/90 backdrop-blur-md px-4 py-1.5 rounded-full text-xs font-mono font-bold text-neonRed border border-borderSubtle shadow-lg">
                                {{ $project->category }}
                            </div>
                        </div>
                        <div class="p-8">
                            <h3 class="text-xl font-bold text-white group-hover:text-neonRed transition">{{ $project->title }}</h3>
                            <p class="text-gray-400 text-sm mt-3 line-clamp-2 leading-relaxed font-light">{{ $project->short_description }}</p>
                        </div>
                    </div>
                    <div class="px-8 pb-8 pt-0 flex items-center justify-between border-t border-borderSubtle mt-4 pt-6">
                        <span class="text-xs font-mono text-gray-500 flex items-center gap-2"><i class="fa-regular fa-eye"></i> {{ $project->views }} views</span>
                        <div class="flex items-center space-x-2">
                            @if($project->figma_url)
                            <a href="{{ $project->figma_url }}" target="_blank" class="bg-indigo-600/20 hover:bg-indigo-600 text-indigo-400 hover:text-white px-3 py-2.5 rounded-xl text-xs font-mono font-bold transition flex items-center space-x-1" title="Lihat Prototype Figma">
                                <i class="fa-brands fa-figma"></i>
                            </a>
                            @endif
                            <a href="/project/{{ $project->slug }}" class="bg-neonRed/10 hover:bg-neonRed text-neonRed hover:text-white px-5 py-2.5 rounded-xl text-xs font-mono font-bold uppercase tracking-wider transition flex items-center space-x-2">
                                <span>Case Study</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-24 glass-card border border-borderSubtle rounded-3xl">
                    <p class="text-gray-400 text-base font-mono">No projects found in this sector.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- EXPERIENCE & ABOUT -->
    <section id="experience" class="py-28 border-t border-borderSubtle scroll-section">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div class="glass-card p-10 rounded-3xl border border-borderSubtle shadow-xl space-y-6">
                    <span class="text-xs font-mono uppercase tracking-widest text-neonRed bg-neonRed/10 px-4 py-1.5 rounded-full border border-neonRed/20">Background</span>
                    <h2 class="text-3xl font-black text-white">Executive Profile</h2>
                    <p class="text-gray-300 leading-relaxed text-sm sm:text-base font-light">
                        Farrelzzzzzzz adalah seorang Director & Creative Technologist yang telah berpengalaman bertahun-tahun dalam memimpin pengembangan produk digital lintas platform. Menguasai arsitektur sistem web skala enterprise, 3D graphics rendering, dan desain UI/UX mendalam.
                    </p>
                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <div class="bg-obsidian border border-borderSubtle p-5 rounded-2xl">
                            <div class="text-neonRed font-bold font-mono text-base">UI/UX Systems</div>
                            <div class="text-xs text-gray-400 mt-1 font-light">Figma, Design Tokens, User Testing.</div>
                        </div>
                        <div class="bg-obsidian border border-borderSubtle p-5 rounded-2xl">
                            <div class="text-neonRed font-bold font-mono text-base">WebGL & 3D</div>
                            <div class="text-xs text-gray-400 mt-1 font-light">Three.js, Blender, GLSL Shaders.</div>
                        </div>
                    </div>
                </div>

                <div class="glass-card p-10 rounded-3xl border border-borderSubtle shadow-xl space-y-6">
                    <span class="text-xs font-mono uppercase tracking-widest text-neonRed bg-neonRed/10 px-4 py-1.5 rounded-full border border-neonRed/20">Timeline</span>
                    <h2 class="text-3xl font-black text-white">Career Milestones</h2>
                    <div class="space-y-4">
                        <div class="bg-obsidian border border-borderSubtle p-6 rounded-2xl">
                            <div class="flex justify-between items-start">
                                <h4 class="font-bold text-white text-sm">Lead Creative Technologist</h4>
                                <span class="text-xs font-mono bg-neonRed/10 text-neonRed px-3 py-1 rounded-full font-bold">2024 - Present</span>
                            </div>
                            <p class="text-xs text-gray-400 mt-1 font-light">Studiokreatif Digital • Full-time</p>
                        </div>

                        <div class="bg-obsidian border border-borderSubtle p-6 rounded-2xl">
                            <div class="flex justify-between items-start">
                                <h4 class="font-bold text-white text-sm">Senior 3D & UI Specialist</h4>
                                <span class="text-xs font-mono bg-borderSubtle text-gray-300 px-3 py-1 rounded-full font-bold">2022 - 2024</span>
                            </div>
                            <p class="text-xs text-gray-400 mt-1 font-light">Apex Studio • Remote</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACT & CONNECT -->
    <section id="contact" class="py-28 bg-panel border-t border-borderSubtle scroll-section">
        <div class="max-w-4xl mx-auto px-6 glass-card rounded-3xl p-10 lg:p-16 border border-borderSubtle shadow-2xl relative">
            <div class="text-center max-w-lg mx-auto mb-12">
                <span class="text-xs font-mono uppercase tracking-widest text-neonRed bg-neonRed/10 px-4 py-1.5 rounded-full border border-neonRed/20">Transmission</span>
                <h2 class="text-4xl font-black text-white mt-4">Initiate Partnership</h2>
                <p class="text-gray-400 text-sm mt-3 font-light">Diskusikan kebutuhan proyek digital skala enterprise Anda bersama saya.</p>
            </div>

            <form onsubmit="event.preventDefault(); alert('Transmisi berhasil! Pesan Anda telah diterima.');" class="space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-mono text-gray-400 uppercase tracking-widest mb-2">Nama Lengkap</label>
                        <input type="text" required placeholder="Cth: Alexander..." class="w-full bg-obsidian border border-borderSubtle rounded-2xl px-5 py-4 text-sm text-white focus:outline-none focus:border-neonRed transition">
                    </div>
                    <div>
                        <label class="block text-xs font-mono text-gray-400 uppercase tracking-widest mb-2">Email Perusahaan</label>
                        <input type="email" required placeholder="name@company.com..." class="w-full bg-obsidian border border-borderSubtle rounded-2xl px-5 py-4 text-sm text-white focus:outline-none focus:border-neonRed transition">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-mono text-gray-400 uppercase tracking-widest mb-2">Pesan & Kebutuhan Proyek</label>
                    <textarea rows="4" required placeholder="Tuliskan detail ruang lingkup proyek..." class="w-full bg-obsidian border border-borderSubtle rounded-2xl px-5 py-4 text-sm text-white focus:outline-none focus:border-neonRed transition"></textarea>
                </div>
                <div class="text-center pt-2">
                    <button type="submit" class="bg-neonRed hover:bg-red-600 text-white px-10 py-5 rounded-2xl font-mono text-xs uppercase tracking-widest font-bold shadow-2xl shadow-neonGlow transition w-full sm:w-auto">
                        Kirim Transmisi Pesan
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-obsidian border-t border-borderSubtle py-16 text-center text-xs font-mono text-gray-500">
        <p>© 2026 FARRELZZZZZZZ. EXECUTIVE PORTFOLIO. POWERED BY LARAVEL & MULTIPLE WEBGL ENGINES.</p>
        <div class="mt-6"><a href="/admin/login" class="text-neonRed hover:underline font-bold uppercase tracking-widest">🔒 Admin Dashboard Access</a></div>
    </footer>

    <!-- PRELOADER & GSAP ANIMATIONS SCRIPT -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            let progress = 0;
            const counter = document.getElementById('loader-progress');
            const preloader = document.getElementById('preloader');

            const interval = setInterval(() => {
                progress += Math.floor(Math.random() * 20) + 15;
                if (progress >= 100) {
                    progress = 100;
                    clearInterval(interval);
                    setTimeout(() => {
                        preloader.style.opacity = '0';
                        preloader.style.visibility = 'hidden';
                        triggerGsapAnimations();
                    }, 500);
                }
                counter.innerText = progress + '%';
            }, 80);
        });

        function triggerGsapAnimations() {
            gsap.registerPlugin(ScrollTrigger);

            gsap.from(".hero-content > *", {
                y: 60,
                opacity: 0,
                duration: 1.2,
                stagger: 0.2,
                ease: "power3.out"
            });

            gsap.from(".hero-3d-wrapper", {
                scale: 0.85,
                opacity: 0,
                duration: 1.4,
                ease: "power3.out",
                delay: 0.3
            });

            gsap.utils.toArray(".scroll-section").forEach(section => {
                gsap.from(section, {
                    scrollTrigger: {
                        trigger: section,
                        start: "top 85%",
                        toggleActions: "play none none none"
                    },
                    y: 70,
                    opacity: 0,
                    duration: 1.1,
                    ease: "power3.out"
                });
            });
        }
    </script>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const icon = document.getElementById('menu-icon');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-xmark');
            } else {
                menu.classList.add('hidden');
                icon.classList.remove('fa-xmark');
                icon.classList.add('fa-bars');
            }
        }
    </script>

    <!-- THREE.JS MULTIPLE 3D SCRIPTS -->
    <script>
        let heroScene, heroCamera, heroRenderer, heroMesh, heroDragging = false, prevHeroMouse = {x: 0, y: 0};
        function initHero3D() {
            const container = document.getElementById('hero-3d-container');
            heroScene = new THREE.Scene();
            heroCamera = new THREE.PerspectiveCamera(50, container.clientWidth / container.clientHeight, 0.1, 1000);
            heroCamera.position.set(0, 0, 5);
            heroRenderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
            heroRenderer.setSize(container.clientWidth, container.clientHeight);
            heroRenderer.setPixelRatio(window.devicePixelRatio);
            container.appendChild(heroRenderer.domElement);

            heroScene.add(new THREE.AmbientLight(0xffffff, 1.5));
            const pLight = new THREE.PointLight(0xff1736, 4, 50);
            pLight.position.set(3, 3, 3);
            heroScene.add(pLight);

            const geometry = new THREE.IcosahedronGeometry(1.6, 0);
            const material = new THREE.MeshStandardMaterial({ color: 0x111118, roughness: 0.1, metalness: 0.95 });
            heroMesh = new THREE.Mesh(geometry, material);
            heroScene.add(heroMesh);

            const innerGeo = new THREE.SphereGeometry(0.8, 32, 32);
            const innerMat = new THREE.MeshBasicMaterial({ color: 0xff1736 });
            heroMesh.add(new THREE.Mesh(innerGeo, innerMat));

            container.addEventListener('mousedown', (e) => { heroDragging = true; prevHeroMouse = { x: e.clientX, y: e.clientY }; });
            window.addEventListener('mousemove', (e) => {
                if (!heroDragging) return;
                heroMesh.rotation.y += (e.clientX - prevHeroMouse.x) * 0.01;
                heroMesh.rotation.x += (e.clientY - prevHeroMouse.y) * 0.01;
                prevHeroMouse = { x: e.clientX, y: e.clientY };
            });
            window.addEventListener('mouseup', () => { heroDragging = false; });

            animateHero();
        }
        function animateHero() {
            requestAnimationFrame(animateHero);
            if (!heroDragging) { heroMesh.rotation.y += 0.006; heroMesh.rotation.x += 0.003; }
            heroRenderer.render(heroScene, heroCamera);
        }

        let carScene, carCamera, carRenderer, carGroup, carDragging = false, prevCarMouse = {x: 0, y: 0};
        function initCar3D() {
            const container = document.getElementById('car-3d-container');
            carScene = new THREE.Scene();
            carCamera = new THREE.PerspectiveCamera(60, container.clientWidth / container.clientHeight, 0.1, 1000);
            carCamera.position.set(0, 2.5, 5.5);
            carCamera.lookAt(0, 0, 0);
            carRenderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
            carRenderer.setSize(container.clientWidth, container.clientHeight);
            container.appendChild(carRenderer.domElement);

            carScene.add(new THREE.AmbientLight(0xffffff, 1.2));
            const dLight = new THREE.DirectionalLight(0xff1736, 3);
            dLight.position.set(5, 8, 5);
            carScene.add(dLight);

            carGroup = new THREE.Group();
            const body = new THREE.Mesh(new THREE.BoxGeometry(2.8, 0.6, 1.4), new THREE.MeshStandardMaterial({ color: 0x111, metalness: 0.9, roughness: 0.2 }));
            body.position.y = 0.3;
            carGroup.add(body);
            const cabin = new THREE.Mesh(new THREE.BoxGeometry(1.4, 0.5, 1.2), new THREE.MeshStandardMaterial({ color: 0xff1736, metalness: 0.5, roughness: 0.3 }));
            cabin.position.set(-0.1, 0.75, 0);
            carGroup.add(cabin);
            carScene.add(carGroup);

            container.addEventListener('mousedown', (e) => { carDragging = true; prevCarMouse = { x: e.clientX, y: e.clientY }; });
            window.addEventListener('mousemove', (e) => {
                if (!carDragging) return;
                carGroup.rotation.y += (e.clientX - prevCarMouse.x) * 0.01;
                prevCarMouse = { x: e.clientX, y: e.clientY };
            });
            window.addEventListener('mouseup', () => { carDragging = false; });
            animateCar();
        }
        function animateCar() {
            requestAnimationFrame(animateCar);
            if (!carDragging) carGroup.rotation.y += 0.005;
            carRenderer.render(carScene, carCamera);
        }
        function resetCarCamera() { carGroup.rotation.set(0, 0, 0); }

        let droneScene, droneCamera, droneRenderer, droneGroup, droneDragging = false, prevDroneMouse = {x: 0, y: 0};
        function initDrone3D() {
            const container = document.getElementById('drone-3d-container');
            droneScene = new THREE.Scene();
            droneCamera = new THREE.PerspectiveCamera(60, container.clientWidth / container.clientHeight, 0.1, 1000);
            droneCamera.position.set(0, 2.5, 5.5);
            droneCamera.lookAt(0, 0, 0);
            droneRenderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
            droneRenderer.setSize(container.clientWidth, container.clientHeight);
            container.appendChild(droneRenderer.domElement);

            droneScene.add(new THREE.AmbientLight(0xffffff, 1.5));
            const dLight = new THREE.DirectionalLight(0x3b82f6, 3);
            dLight.position.set(5, 8, 5);
            droneScene.add(dLight);

            droneGroup = new THREE.Group();
            const core = new THREE.Mesh(new THREE.OctahedronGeometry(1.0, 0), new THREE.MeshStandardMaterial({ color: 0x181822, metalness: 0.8, roughness: 0.2 }));
            droneGroup.add(core);
            droneScene.add(droneGroup);

            container.addEventListener('mousedown', (e) => { droneDragging = true; prevDroneMouse = { x: e.clientX, y: e.clientY }; });
            window.addEventListener('mousemove', (e) => {
                if (!droneDragging) return;
                droneGroup.rotation.y += (e.clientX - prevDroneMouse.x) * 0.01;
                droneGroup.rotation.x += (e.clientY - prevDroneMouse.y) * 0.01;
                prevDroneMouse = { x: e.clientX, y: e.clientY };
            });
            window.addEventListener('mouseup', () => { droneDragging = false; });
            animateDrone();
        }
        function animateDrone() {
            requestAnimationFrame(animateDrone);
            if (!droneDragging) { droneGroup.rotation.y += 0.007; droneGroup.rotation.z += 0.003; }
            droneRenderer.render(droneScene, droneCamera);
        }
        function resetDroneCamera() { droneGroup.rotation.set(0, 0, 0); }

        let torusScene, torusCamera, torusRenderer, torusMesh, torusDragging = false, prevTorusMouse = {x: 0, y: 0};
        function initTorus3D() {
            const container = document.getElementById('torus-3d-container');
            torusScene = new THREE.Scene();
            torusCamera = new THREE.PerspectiveCamera(60, container.clientWidth / container.clientHeight, 0.1, 1000);
            torusCamera.position.set(0, 0, 4.5);
            torusRenderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
            torusRenderer.setSize(container.clientWidth, container.clientHeight);
            container.appendChild(torusRenderer.domElement);

            torusScene.add(new THREE.AmbientLight(0xffffff, 1.2));
            const tLight = new THREE.DirectionalLight(0xff1736, 3);
            tLight.position.set(3, 3, 3);
            torusScene.add(tLight);

            torusMesh = new THREE.Mesh(new THREE.TorusKnotGeometry(1.1, 0.35, 128, 32), new THREE.MeshStandardMaterial({ color: 0x22222f, roughness: 0.2, metalness: 0.9, wireframe: false }));
            torusScene.add(torusMesh);

            container.addEventListener('mousedown', (e) => { torusDragging = true; prevTorusMouse = { x: e.clientX, y: e.clientY }; });
            window.addEventListener('mousemove', (e) => {
                if (!torusDragging) return;
                torusMesh.rotation.y += (e.clientX - prevTorusMouse.x) * 0.01;
                torusMesh.rotation.x += (e.clientY - prevTorusMouse.y) * 0.01;
                prevTorusMouse = { x: e.clientX, y: e.clientY };
            });
            window.addEventListener('mouseup', () => { torusDragging = false; });
            animateTorus();
        }
        function animateTorus() {
            requestAnimationFrame(animateTorus);
            if (!torusDragging) { torusMesh.rotation.y += 0.005; torusMesh.rotation.z += 0.002; }
            torusRenderer.render(torusScene, torusCamera);
        }
        function resetTorusCamera() { torusMesh.rotation.set(0, 0, 0); }

        window.addEventListener('load', () => {
            initHero3D();
            initCar3D();
            initDrone3D();
            initTorus3D();
        });
    </script>

    <!-- DUAL EDITORIAL LIBRARY -->
    <script>
        let m1Sheet = 0;
        function updateMag1() {
            const s1 = document.getElementById('m1-sheet-1');
            const s2 = document.getElementById('m1-sheet-2');
            if (m1Sheet >= 1) { s1.classList.add('flipped'); s1.style.zIndex = 10; } else { s1.classList.remove('flipped'); s1.style.zIndex = 20; }
            if (m1Sheet >= 2) { s2.classList.add('flipped'); s2.style.zIndex = 11; } else { s2.classList.remove('flipped'); s2.style.zIndex = 10; }
            document.getElementById('page-indicator-1').innerText = ["Cover", "Hal. 1-2", "Back Cover"][m1Sheet] || "End";
        }
        function nextPage1() { if (m1Sheet < 2) { m1Sheet++; updateMag1(); } else { m1Sheet = 0; updateMag1(); } }
        function prevPage1() { if (m1Sheet > 0) { m1Sheet--; updateMag1(); } }

        let m2Sheet = 0;
        function updateMag2() {
            const s1 = document.getElementById('m2-sheet-1');
            const s2 = document.getElementById('m2-sheet-2');
            if (m2Sheet >= 2) { s2.classList.add('flipped'); s2.style.zIndex = 11; } else { s2.classList.remove('flipped'); s2.style.zIndex = 10; }
            if (m2Sheet >= 1) { s1.classList.add('flipped'); s1.style.zIndex = 10; } else { s1.classList.remove('flipped'); s1.style.zIndex = 20; }
            document.getElementById('page-indicator-2').innerText = ["Cover", "Hal. 1-2", "Back Cover"][m2Sheet] || "End";
        }
        function nextPage2() { if (m2Sheet < 2) { m2Sheet++; updateMag2(); } else { m2Sheet = 0; updateMag2(); } }
        function prevPage2() { if (m2Sheet > 0) { m2Sheet--; updateMag2(); } }
    </script>

</body>
</html>
