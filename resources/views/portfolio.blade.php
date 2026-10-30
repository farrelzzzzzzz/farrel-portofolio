<!DOCTYPE html>
<html lang="id" class="scroll-smooth" style="background-color: #050308;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farrelzzzzzzz — Executive Creative Developer & 3D Director</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Three.js for Multiple 3D WebGL Canvases (r152 includes CapsuleGeometry natively) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/0.152.2/three.min.js"></script>
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

        @keyframes bgGradientShift {
            0%   { background-color: #0d0814; filter: hue-rotate(0deg); }
            10%  { background-color: #1a0f2e; filter: hue-rotate(36deg); }
            20%  { background-color: #0e1e38; filter: hue-rotate(72deg); }
            30%  { background-color: #240e3c; filter: hue-rotate(108deg); }
            40%  { background-color: #0e2840; filter: hue-rotate(144deg); }
            50%  { background-color: #201035; filter: hue-rotate(180deg); }
            60%  { background-color: #151a3a; filter: hue-rotate(216deg); }
            70%  { background-color: #2d0d2b; filter: hue-rotate(252deg); }
            80%  { background-color: #0c2635; filter: hue-rotate(288deg); }
            90%  { background-color: #1d0928; filter: hue-rotate(324deg); }
            100% { background-color: #0d0814; filter: hue-rotate(360deg); }
        }
        .animated-bg {
            background-color: #050308;
        }
        .animated-bg::before {
            content: "";
            position: fixed;
            inset: 0;
            background-image: linear-gradient(125deg, rgba(13,8,20,0.9), rgba(26,15,46,0.9), rgba(14,30,56,0.9), rgba(36,14,60,0.9));
            background-size: 400% 400%;
            animation: bgGradientShift 10s steps(10, end) infinite;
            z-index: -999;
            pointer-events: none;
            transform: translateZ(0);
        }

        @keyframes meshDrift1 {
            0%   { transform: translate(0px, 0px) scale(1); }
            33%  { transform: translate(50px, 40px) scale(1.08); }
            66%  { transform: translate(-30px, 60px) scale(0.95); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        @keyframes meshDrift2 {
            0%   { transform: translate(0px, 0px) scale(1); }
            33%  { transform: translate(-40px, 50px) scale(1.05); }
            66%  { transform: translate(60px, -30px) scale(1.1); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        @keyframes meshDrift3 {
            0%   { transform: translate(0px, 0px) scale(1); }
            33%  { transform: translate(-50px, -40px) scale(1.08); }
            66%  { transform: translate(40px, 50px) scale(0.92); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        @keyframes meshDrift4 {
            0%   { transform: translate(0px, 0px) scale(1); }
            50%  { transform: translate(-60px, -50px) scale(1.1); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .mesh-1 { animation: meshDrift1 25s ease-in-out infinite; }
        .mesh-2 { animation: meshDrift2 30s ease-in-out infinite; }
        .mesh-3 { animation: meshDrift3 28s ease-in-out infinite; }
        .mesh-4 { animation: meshDrift4 35s ease-in-out infinite; }

        @keyframes textGradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animate-gradient-text {
            background: linear-gradient(270deg, #ff1736, #ffffff, #8b5cf6, #3b82f6, #ff1736);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: textGradientMove 6s ease infinite;
        }

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
<body class="animated-bg text-gray-100 font-sans antialiased selection:bg-neonRed selection:text-white overflow-x-hidden relative">
    <!-- CINEMATIC VIBRANT MESH GRADIENT & SCROLL ENGINE BACKGROUND -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden" style="transform: translateZ(0); will-change: transform;">
        <!-- 1. Rich & Vibrant Ambient Mesh Gradients (Multi-Layer Depth) -->
        <div class="mesh-1 absolute -top-[20%] -left-[10%] w-[75vw] h-[75vw] rounded-full bg-gradient-to-br from-red-800/45 via-rose-800/25 to-transparent blur-[140px]"></div>
        <div class="mesh-2 absolute top-[15%] left-[22%] w-[70vw] h-[70vw] rounded-full bg-gradient-to-tr from-purple-800/45 via-violet-800/25 to-transparent blur-[160px]"></div>
        <div class="mesh-3 absolute top-[5%] -right-[10%] w-[75vw] h-[75vw] rounded-full bg-gradient-to-bl from-cyan-800/40 via-teal-800/20 to-transparent blur-[150px]"></div>
        <div class="mesh-4 absolute -bottom-[25%] right-[10%] w-[80vw] h-[80vw] rounded-full bg-gradient-to-tl from-blue-800/40 via-purple-800/25 to-transparent blur-[170px]"></div>

        <!-- Base Cinematic Lighting Overlay -->
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-purple-900/30 via-[#0d0814]/75 to-[#08050e]"></div>

        <!-- 2. Subtle Perspective Digital Grid Texture -->
        <div class="absolute inset-0 opacity-[0.14]" style="background-image: linear-gradient(to right, rgba(255,255,255,0.15) 1px, transparent 1px), linear-gradient(to bottom, rgba(255,255,255,0.15) 1px, transparent 1px); background-size: 70px 70px; mask-image: radial-gradient(ellipse 70% 60% at 50% 40%, #000 60%, transparent 100%);"></div>

        <!-- 3. Abstract Flowing Curved Lines -->
        <svg class="absolute inset-0 w-full h-full opacity-55" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="cyberGrad1" x1="0%" y1="0%" x2="100%" y2="100%">
                    <stop offset="0%" stop-color="#ff1736" stop-opacity="0.95" />
                    <stop offset="50%" stop-color="#a855f7" stop-opacity="0.7" />
                    <stop offset="100%" stop-color="#00f3ff" stop-opacity="0.2" />
                </linearGradient>
                <linearGradient id="cyberGrad2" x1="100%" y1="0%" x2="0%" y2="100%">
                    <stop offset="0%" stop-color="#00f3ff" stop-opacity="0.9" />
                    <stop offset="50%" stop-color="#3b82f6" stop-opacity="0.6" />
                    <stop offset="100%" stop-color="#ff1736" stop-opacity="0.2" />
                </linearGradient>
            </defs>
            <path d="M-100,150 Q400,350 900,200 T1800,450" fill="none" stroke="url(#cyberGrad1)" stroke-width="2.2" class="animate-pulse" style="animation-duration: 8s;" />
            <path d="M0,550 Q600,150 1200,650 T2000,350" fill="none" stroke="url(#cyberGrad2)" stroke-width="2" class="animate-pulse" style="animation-duration: 10s;" />
            <path d="M-200,850 Q500,450 1400,750 T2200,550" fill="none" stroke="url(#cyberGrad1)" stroke-width="1.8" class="animate-pulse" style="animation-duration: 12s;" />
        </svg>

        <!-- 4. Geometric Architectural Outlines & Parallax Elements -->
        <div id="cyber-parallax-layer" class="absolute inset-0 pointer-events-none transition-transform duration-300 ease-out opacity-85">
            <!-- Wireframe Cube 1 (Top Right) -->
            <div class="absolute top-[12%] right-[8%] w-60 h-60 border border-cyan-400/30 rounded-2xl rotate-12 animate-spin" style="animation: spin 35s linear infinite;">
                <div class="absolute inset-2 border border-purple-400/25 rounded-xl -rotate-45"></div>
            </div>
            <!-- Circular Technical Rings (Bottom Left) -->
            <div class="absolute -bottom-10 -left-10 w-[460px] h-[460px] rounded-full border border-red-500/25 border-dashed animate-spin" style="animation: spin 60s linear infinite;"></div>
            <div class="absolute bottom-10 left-10 w-80 h-80 rounded-full border border-cyan-400/25 border-dashed animate-spin" style="animation: spin 45s linear reverse infinite;"></div>
            <!-- HUD Technical Accents -->
            <div class="absolute top-1/4 left-10 w-8 h-8 border-t-2 border-l-2 border-red-500/50"></div>
            <div class="absolute top-1/4 right-10 w-8 h-8 border-t-2 border-r-2 border-cyan-400/50"></div>
            <div class="absolute bottom-1/4 left-10 w-8 h-8 border-b-2 border-l-2 border-purple-500/50"></div>
            <div class="absolute bottom-1/4 right-10 w-8 h-8 border-b-2 border-r-2 border-yellow-500/50"></div>
        </div>
    </div>

    <!-- SUBTLE SCROLL PROGRESS INDICATOR -->
    <div id="scroll-progress-bar" class="fixed top-0 left-0 h-[3px] bg-gradient-to-r from-neonRed via-purple-500 to-cyan-400 z-[10000] transition-all duration-100 ease-out" style="width: 0%;"></div>

    <!-- CINEMATIC ANIMATION & SCROLL REVEAL ENGINE SCRIPT -->
    <style>
        .reveal-init { opacity: 0; transform: translateY(35px); transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1); will-change: opacity, transform; }
        .reveal-active { opacity: 1; transform: translateY(0); }
        .reveal-left-init { opacity: 0; transform: translateX(-40px); transition: opacity 0.8s ease, transform 0.8s ease; }
        .reveal-left-active { opacity: 1; transform: translateX(0); }
        .reveal-right-init { opacity: 0; transform: translateX(40px); transition: opacity 0.8s ease, transform 0.8s ease; }
        .reveal-right-active { opacity: 1; transform: translateX(0); }
        .reveal-scale-init { opacity: 0; transform: scale(0.92); transition: opacity 0.8s ease, transform 0.8s ease; }
        .reveal-scale-active { opacity: 1; transform: scale(1); }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Mouse Parallax Effect
            document.addEventListener('mousemove', (e) => {
                const layer = document.getElementById('cyber-parallax-layer');
                if (!layer) return;
                const x = (e.clientX / window.innerWidth - 0.5) * 25;
                const y = (e.clientY / window.innerHeight - 0.5) * 25;
                layer.style.transform = `translate3d(${x}px, ${y}px, 0)`;
            });

            // 2. Scroll Progress Bar & Dynamic Ambient Color Shift per Section
            const progressBar = document.getElementById('scroll-progress-bar');
            const mesh1 = document.getElementById('mesh-glow-1');
            const mesh2 = document.getElementById('mesh-glow-2');
            const mesh3 = document.getElementById('mesh-glow-3');

            window.addEventListener('scroll', () => {
                const winScroll = document.documentElement.scrollTop;
                const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const scrolled = (winScroll / height) * 100;
                if (progressBar) progressBar.style.width = scrolled + '%';

                // Section-based Dynamic Ambient Lighting Shift
                const scrollFraction = winScroll / height;
                if (mesh1 && mesh2 && mesh3) {
                    if (scrollFraction < 0.2) {
                        // Hero: Crimson + Purple + Cyan
                        mesh1.style.background = 'linear-gradient(to bottom right, rgba(220, 38, 38, 0.45), rgba(190, 18, 60, 0.35), transparent)';
                        mesh2.style.background = 'linear-gradient(to top right, rgba(147, 51, 234, 0.4), rgba(124, 58, 237, 0.3), transparent)';
                        mesh3.style.background = 'linear-gradient(to bottom left, rgba(6, 182, 212, 0.35), rgba(13, 148, 136, 0.25), transparent)';
                    } else if (scrollFraction < 0.4) {
                        // About / Works: Purple + Blue
                        mesh1.style.background = 'linear-gradient(to bottom right, rgba(147, 51, 234, 0.4), rgba(79, 70, 229, 0.3), transparent)';
                        mesh2.style.background = 'linear-gradient(to top right, rgba(37, 99, 235, 0.35), rgba(99, 102, 241, 0.25), transparent)';
                        mesh3.style.background = 'linear-gradient(to bottom left, rgba(6, 182, 212, 0.3), rgba(59, 130, 246, 0.2), transparent)';
                    } else if (scrollFraction < 0.7) {
                        // 3D Hub / Editorial: Cyan + Purple + Magenta
                        mesh1.style.background = 'linear-gradient(to bottom right, rgba(6, 182, 212, 0.4), rgba(37, 99, 235, 0.3), transparent)';
                        mesh2.style.background = 'linear-gradient(to top right, rgba(219, 39, 119, 0.35), rgba(147, 51, 234, 0.3), transparent)';
                        mesh3.style.background = 'linear-gradient(to bottom left, rgba(168, 85, 247, 0.35), rgba(236, 72, 153, 0.25), transparent)';
                    } else {
                        // Experience / Connect: Deep Purple + Crimson
                        mesh1.style.background = 'linear-gradient(to bottom right, rgba(220, 38, 38, 0.4), rgba(147, 51, 234, 0.35), transparent)';
                        mesh2.style.background = 'linear-gradient(to top right, rgba(88, 28, 135, 0.4), rgba(157, 23, 77, 0.3), transparent)';
                        mesh3.style.background = 'linear-gradient(to bottom left, rgba(225, 29, 72, 0.35), rgba(6, 182, 212, 0.25), transparent)';
                    }
                }
            });

            // 3. IntersectionObserver Scroll Reveal Engine
            const observerOptions = {
                root: null,
                rootMargin: '0px 0px -80px 0px',
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('reveal-active');
                        entry.target.classList.add('reveal-left-active');
                        entry.target.classList.add('reveal-right-active');
                        entry.target.classList.add('reveal-scale-active');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Auto-tag sections and cards with reveal classes safely
            document.querySelectorAll('section > div, .glass-card, h2, h3, p').forEach((el, index) => {
                if (!el.classList.contains('reveal-init')) {
                    el.classList.add('reveal-init');
                    observer.observe(el);
                }
            });
        });
    </script>

    <!-- MOUSE PARALLAX SCRIPT FOR ARCHITECTURAL BACKGROUND -->
    <script>
        document.addEventListener('mousemove', (e) => {
            const layer = document.getElementById('cyber-parallax-layer');
            if (!layer) return;
            const x = (e.clientX / window.innerWidth - 0.5) * 20;
            const y = (e.clientY / window.innerHeight - 0.5) * 20;
            layer.style.transform = `translate(${x}px, ${y}px)`;
        });
    </script>

    <!-- Glowing Star Custom Cursor -->
    <div id="custom-cursor" class="fixed pointer-events-none z-[9999] -translate-x-1/2 -translate-y-1/2 transition-transform duration-75 ease-out text-neonRed hidden lg:flex items-center justify-center drop-shadow-[0_0_15px_#ff1736]">
        <svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor" class="filter drop-shadow-[0_0_8px_#ff1736]">
            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
            <polygon points="12 22 8.91 15.74 2 14.73 7 9.86 5.82 2.98 12 6.23 18.18 2.98 17 9.86 22 14.73 15.09 15.74 12 22"></polygon>
        </svg>
    </div>

    <!-- PRELOADER ANIMATION SCREEN -->
    <div id="preloader">
        <div class="relative flex items-center justify-center mb-6">
            <div class="w-20 h-20 rounded-full border-2 border-borderSubtle border-t-neonRed animate-spin"></div>
            <span class="absolute font-mono text-xs text-neonRed font-bold" id="loader-progress">0%</span>
        </div>
        <h2 class="text-xl font-black tracking-widest text-white font-mono">FARRELZZZZZZZ</h2>
        <p class="text-xs font-mono text-gray-500 mt-2 tracking-wider">INITIALIZING 3D WEBGL & ASSETS...</p>
    </div>

    <!-- FLOATING INTERACTIVE PARTICLE CANVAS BACKGROUND -->
    <canvas id="bg-particle-canvas" class="fixed inset-0 pointer-events-none z-0 block w-full h-full opacity-90"></canvas>

    <!-- CUSTOM INTERACTIVE NEON GLOWING LINE STAR MOUSE FOLLOWER -->
    <div id="custom-cursor" class="fixed pointer-events-none z-[9999] -translate-x-1/2 -translate-y-1/2 transition-transform duration-75 ease-out text-neonRed hidden lg:flex items-center justify-center">
        <svg id="cursor-star" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="filter drop-shadow-[0_0_12px_#ff1736]">
            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
            <polygon points="12 22 8.91 15.74 2 14.73 7 9.86 5.82 2.98 12 6.23 18.18 2.98 17 9.86 22 14.73 15.09 15.74 12 22"></polygon>
        </svg>
    </div>
    <div id="custom-cursor-dot" class="fixed pointer-events-none z-[9999] w-1.5 h-1.5 rounded-full bg-white -translate-x-1/2 -translate-y-1/2 hidden lg:block shadow-[0_0_10px_#ffffff,0_0_20px_#ff1736]"></div>

    <!-- Executive Responsive Navbar -->
    <header class="fixed top-2 left-2 right-2 sm:top-4 sm:left-4 sm:right-4 max-w-7xl mx-auto z-50 bg-obsidian/85 backdrop-blur-3xl border border-borderSubtle rounded-2xl sm:rounded-3xl transition-all duration-300 shadow-[0_20px_50px_rgba(0,0,0,0.9)]">
        <div class="px-3 sm:px-6 h-16 sm:h-20 flex items-center justify-between gap-2">
            <a href="#home" class="flex items-center space-x-2 sm:space-x-3.5 group flex-shrink-0">
                <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-2xl glass-card flex items-center justify-center border border-neonRed/60 group-hover:border-neonRed transition shadow-lg shadow-neonGlow">
                    <i class="fa-solid fa-cube text-neonRed text-sm sm:text-lg animate-pulse"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-xs sm:text-base font-black tracking-widest text-white font-mono flex items-center space-x-1 sm:space-x-1.5">
                        <span>FARREL</span>
                        <span class="text-neonRed hidden sm:inline">BALAPRADHANA</span>
                    </span>
                    <span class="text-[8px] sm:text-[9px] font-mono text-gray-400 tracking-wider uppercase hidden sm:block">UI/UX & 3D Creative Studio</span>
                </div>
            </a>
            
            <nav class="hidden xl:flex items-center space-x-1.5 glass-card px-4 py-2 rounded-full border border-borderSubtle text-[11px] font-mono uppercase tracking-widest text-gray-300">
                <a href="#home" class="px-4 py-2 rounded-full hover:text-white hover:bg-neonRed/20 hover:shadow-[0_0_15px_rgba(255,59,48,0.3)] transition-all duration-300">01. Overview</a>
                <a href="#about" class="px-4 py-2 rounded-full hover:text-white hover:bg-neonRed/20 hover:shadow-[0_0_15px_rgba(255,59,48,0.3)] transition-all duration-300">02. About</a>
                <a href="#music-production" class="px-4 py-2 rounded-full hover:text-white hover:bg-amber-400/20 hover:shadow-[0_0_15px_rgba(251,191,36,0.3)] transition-all duration-300">03. Music</a>
                <a href="#3d-showroom" class="px-4 py-2 rounded-full hover:text-white hover:bg-neonRed/20 hover:shadow-[0_0_15px_rgba(255,59,48,0.3)] transition-all duration-300">04. 3D Hub</a>
                <a href="#editorial-library" class="px-4 py-2 rounded-full hover:text-white hover:bg-neonRed/20 hover:shadow-[0_0_15px_rgba(255,59,48,0.3)] transition-all duration-300">05. Editorial</a>
                <a href="#portfolio" class="px-4 py-2 rounded-full hover:text-white hover:bg-neonRed/20 hover:shadow-[0_0_15px_rgba(255,59,48,0.3)] transition-all duration-300">06. Works</a>
                <a href="#experience" class="px-4 py-2 rounded-full hover:text-white hover:bg-neonRed/20 hover:shadow-[0_0_15px_rgba(255,59,48,0.3)] transition-all duration-300">07. Experience</a>
                <a href="#contact" class="px-4 py-2 rounded-full hover:text-white hover:bg-neonRed/20 hover:shadow-[0_0_15px_rgba(255,59,48,0.3)] transition-all duration-300">08. Connect</a>
            </nav>

            <div class="flex items-center space-x-2 sm:space-x-4">
                <!-- LANGUAGE SWITCHER -->
                <div class="flex items-center space-x-1 bg-obsidian border border-borderSubtle px-2 py-1 rounded-xl text-[11px] font-mono">
                    <a href="{{ route('locale.switch', 'id') }}" class="px-2 py-1 rounded-lg transition {{ app()->getLocale() == 'id' ? 'bg-neonRed text-white font-bold' : 'text-gray-400 hover:text-white' }}">ID</a>
                    <a href="{{ route('locale.switch', 'en') }}" class="px-2 py-1 rounded-lg transition {{ app()->getLocale() == 'en' ? 'bg-neonRed text-white font-bold' : 'text-gray-400 hover:text-white' }}">EN</a>
                </div>

                <div class="hidden md:flex items-center space-x-2 text-[10px] font-mono text-gray-400 bg-obsidian border border-borderSubtle px-3.5 py-2 rounded-xl">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                    <span>ONLINE</span>
                </div>

                <a href="#contact" class="bg-gradient-to-r from-neonRed to-red-600 hover:from-red-600 hover:to-red-700 text-white px-3 sm:px-6 py-2 sm:py-3 rounded-xl sm:rounded-2xl text-[10px] sm:text-xs font-mono font-bold uppercase tracking-wider shadow-lg shadow-neonGlow transition transform hover:scale-105 flex items-center space-x-1 sm:space-x-2">
                    <span>Start</span>
                    <i class="fa-solid fa-arrow-right text-[9px] sm:text-[10px]"></i>
                </a>
                
                <button onclick="toggleMobileMenu()" class="xl:hidden text-gray-300 hover:text-white p-2 sm:p-3 focus:outline-none glass-card rounded-xl sm:rounded-2xl border border-borderSubtle" aria-label="Toggle Menu">
                    <i class="fa-solid fa-bars text-sm sm:text-lg" id="menu-icon"></i>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden xl:hidden bg-obsidian/95 border-t border-borderSubtle px-4 sm:px-6 py-4 sm:py-6 space-y-1 sm:space-y-4 backdrop-blur-2xl rounded-b-2xl sm:rounded-b-3xl shadow-2xl max-h-[70vh] overflow-y-auto">
            <a href="#home" onclick="toggleMobileMenu()" class="block text-xs font-mono uppercase tracking-widest text-gray-300 hover:text-neonRed transition py-2 sm:py-2.5 border-b border-borderSubtle/50">01. Overview</a>
            <a href="#about" onclick="toggleMobileMenu()" class="block text-xs font-mono uppercase tracking-widest text-gray-300 hover:text-neonRed transition py-2 sm:py-2.5 border-b border-borderSubtle/50">02. About</a>
            <a href="#music-production" onclick="toggleMobileMenu()" class="block text-xs font-mono uppercase tracking-widest text-gray-300 hover:text-amber-400 transition py-2 sm:py-2.5 border-b border-borderSubtle/50">03. Music</a>
            <a href="#3d-showroom" onclick="toggleMobileMenu()" class="block text-xs font-mono uppercase tracking-widest text-gray-300 hover:text-neonRed transition py-2 sm:py-2.5 border-b border-borderSubtle/50">04. 3D Hub</a>
            <a href="#editorial-library" onclick="toggleMobileMenu()" class="block text-xs font-mono uppercase tracking-widest text-gray-300 hover:text-neonRed transition py-2 sm:py-2.5 border-b border-borderSubtle/50">05. Editorial</a>
            <a href="#portfolio" onclick="toggleMobileMenu()" class="block text-xs font-mono uppercase tracking-widest text-gray-300 hover:text-neonRed transition py-2 sm:py-2.5 border-b border-borderSubtle/50">06. Works</a>
            <a href="#experience" onclick="toggleMobileMenu()" class="block text-xs font-mono uppercase tracking-widest text-gray-300 hover:text-neonRed transition py-2 sm:py-2.5 border-b border-borderSubtle/50">07. Experience</a>
            <a href="#contact" onclick="toggleMobileMenu()" class="block text-xs font-mono uppercase tracking-widest text-gray-300 hover:text-neonRed transition py-2 sm:py-2.5">08. Connect</a>
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

                    <!-- Decorative Tech Stats & Cyber Badge Bar -->
                    <div class="flex flex-wrap items-center gap-3 pt-1">
                        <div class="inline-flex items-center space-x-2 px-3 py-1 bg-white/5 rounded-lg border border-white/10 text-[11px] font-mono text-gray-300">
                            <span class="text-neonRed font-bold">//</span> V.2026 RELEASE
                        </div>
                        <div class="inline-flex items-center space-x-2 px-3 py-1 bg-white/5 rounded-lg border border-white/10 text-[11px] font-mono text-gray-300">
                            <span class="text-cyan-400 font-bold">SYS_ID:</span> BALAPRADHANA_CORE
                        </div>
                        <div class="inline-flex items-center space-x-2 px-3 py-1 bg-white/5 rounded-lg border border-white/10 text-[11px] font-mono text-emerald-400">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span> ONLINE_READY
                        </div>
                    </div>
                    
                    <h1 class="text-5xl sm:text-7xl font-black tracking-tighter text-white leading-[0.95] uppercase">
                        <span class="block animate-gradient-text">ENGINEERING</span>
                        <span class="block animate-gradient-text mt-1">THE DIGITAL</span>
                        <span class="block animate-gradient-text mt-1" style="text-shadow: 0 0 30px rgba(255, 23, 54, 0.6), 0 0 60px rgba(255, 23, 54, 0.3);">FUTURE.</span>
                    </h1>

                    <!-- Subtly Contasted Hero Text Backdrop -->
                    <div class="relative p-6 -ml-6 rounded-3xl bg-black/40 backdrop-blur-md border border-white/10 shadow-2xl">
                        <p class="text-gray-200 text-base sm:text-lg max-w-xl leading-relaxed font-light">
                            Saya <span class="text-white font-bold text-lg tracking-wide drop-shadow-[0_2px_10px_rgba(255,255,255,0.3)]">Farrel Balapradhana</span>. <span class="text-rose-200 font-semibold tracking-wide">Senior Creative Technologist & 3D Art Director</span> <span class="text-gray-300 font-light">yang merancang web berperforma tinggi, interaksi 3D kompleks, dan publikasi digital imersif.</span>
                        </p>
                    </div>

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

    <!-- ABOUT SECTION -->
    <section id="about" class="py-28 bg-panel border-t border-borderSubtle scroll-section relative overflow-hidden">
        <div class="absolute top-1/2 right-0 w-[500px] h-[500px] bg-neonRed/5 rounded-full blur-[150px] pointer-events-none"></div>
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
                
                <!-- Profile Photo / Visual Placeholder Side -->
                <div class="lg:col-span-5 relative flex justify-center">
                    <div class="relative w-full max-w-md h-[520px] glass-card rounded-3xl p-4 shadow-2xl overflow-hidden group border border-borderSubtle flex flex-col justify-between">
                        <div class="absolute top-6 left-6 z-20 bg-obsidian/90 px-4 py-2 rounded-xl border border-borderSubtle text-[10px] font-mono tracking-widest text-neonRed flex items-center space-x-2">
                            <i class="fa-solid fa-user-shield animate-pulse"></i>
                            <span>CREATIVE DIRECTOR & UI ARCHITECT</span>
                        </div>
                        
                        <div class="w-full h-full rounded-2xl bg-obsidian border border-borderSubtle overflow-hidden relative flex items-center justify-center">
                            <!-- User Profile Photo -->
                            <img src="{{ asset('images/profile-photo.png') }}" alt="Farrel Balapradhana" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-obsidian/60 via-transparent to-transparent pointer-events-none"></div>
                            <div class="absolute bottom-6 left-6 right-6 z-20 space-y-2">
                                <div class="font-mono text-xs text-white tracking-widest uppercase font-bold drop-shadow-lg">
                                    Farrel Balapradhana
                                </div>
                                <p class="text-[10px] text-gray-200 font-light drop-shadow">
                                    UI/UX Architect & 3D Creative Director
                                </p>
                            </div>
                        </div>

                        <div class="absolute bottom-6 left-6 right-6 z-20 bg-obsidian/90 backdrop-blur-md px-4 py-3 rounded-xl border border-borderSubtle flex items-center justify-between">
                            <span class="text-[10px] font-mono text-gray-400">STATUS</span>
                            <span class="text-[10px] font-mono text-neonRed font-bold flex items-center space-x-2">
                                <span class="w-2 h-2 rounded-full bg-neonRed animate-ping"></span>
                                <span>READY FOR INNOVATION</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Bio & Skills Text Side -->
                <div class="lg:col-span-7 space-y-8">
                    <div class="inline-flex items-center space-x-3 px-4 py-2 glass-card rounded-full text-neonRed text-xs font-mono tracking-widest border border-neonRed/30">
                        <span class="w-2 h-2 rounded-full bg-neonRed animate-pulse"></span>
                        <span>02. ABOUT ME & EXPERTISE</span>
                    </div>

                    <h2 class="text-4xl sm:text-5xl font-black tracking-tight text-white leading-tight">
                        <span class="animate-gradient-text">MENGGABUNGKAN ESTETIKA VISUAL & TEKNOLOGI 3D</span>
                    </h2>

                    <p class="text-gray-400 text-base sm:text-lg leading-relaxed font-light">
                        Halo! Saya <strong class="text-white font-normal">Farrel Balapradhana</strong>. Seorang profesional di bidang UI/UX Design dan Creative 3D Development dengan dedikasi tinggi terhadap detail presisi, performa web interaktif, dan pengalaman pengguna yang luar biasa.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="glass-card p-5 rounded-2xl border border-borderSubtle space-y-2 group hover:border-neonRed transition duration-300">
                            <div class="text-neonRed font-mono text-xs font-bold uppercase tracking-wider flex items-center space-x-2">
                                <i class="fa-solid fa-pen-nib"></i>
                                <span>UI/UX & Art Direction</span>
                            </div>
                            <p class="text-xs text-gray-400 font-light leading-relaxed">
                                Merancang antarmuka produk digital modern, wireframing interaktif, dan sistem desain yang konsisten.
                            </p>
                        </div>

                        <div class="glass-card p-5 rounded-2xl border border-borderSubtle space-y-2 group hover:border-neonRed transition duration-300">
                            <div class="text-neonRed font-mono text-xs font-bold uppercase tracking-wider flex items-center space-x-2">
                                <i class="fa-solid fa-cube"></i>
                                <span>3D Interactive Web</span>
                            </div>
                            <p class="text-xs text-gray-400 font-light leading-relaxed">
                                Mengintegrasikan model 3D real-time berkinerja tinggi menggunakan WebGL, Three.js, dan shader kustom.
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4 pt-4 border-t border-borderSubtle">
                        <div>
                            <h4 class="text-xs font-mono text-neonRed uppercase font-bold tracking-wider mb-2">Software & Tools Mastery</h4>
                            <div class="flex flex-wrap gap-2">
                                <span class="bg-obsidian border border-borderSubtle text-gray-300 px-3 py-1.5 rounded-xl text-xs font-mono">Adobe InDesign</span>
                                <span class="bg-obsidian border border-borderSubtle text-gray-300 px-3 py-1.5 rounded-xl text-xs font-mono">Adobe Animate</span>
                                <span class="bg-obsidian border border-borderSubtle text-gray-300 px-3 py-1.5 rounded-xl text-xs font-mono">Adobe Photoshop</span>
                                <span class="bg-obsidian border border-borderSubtle text-gray-300 px-3 py-1.5 rounded-xl text-xs font-mono">Adobe Illustrator</span>
                                <span class="bg-obsidian border border-borderSubtle text-gray-300 px-3 py-1.5 rounded-xl text-xs font-mono">Adobe Premiere Pro</span>
                                <span class="bg-obsidian border border-borderSubtle text-gray-300 px-3 py-1.5 rounded-xl text-xs font-mono">Adobe After Effects</span>
                                <span class="bg-obsidian border border-borderSubtle text-gray-300 px-3 py-1.5 rounded-xl text-xs font-mono">Adobe Lightroom</span>
                                <span class="bg-obsidian border border-borderSubtle text-gray-300 px-3 py-1.5 rounded-xl text-xs font-mono">CorelDRAW</span>
                                <span class="bg-obsidian border border-borderSubtle text-gray-300 px-3 py-1.5 rounded-xl text-xs font-mono">Blender</span>
                                <span class="bg-obsidian border border-borderSubtle text-gray-300 px-3 py-1.5 rounded-xl text-xs font-mono">Unity 3D</span>
                                <span class="bg-obsidian border border-borderSubtle text-gray-300 px-3 py-1.5 rounded-xl text-xs font-mono">VS Code</span>
                                <span class="bg-obsidian border border-borderSubtle text-gray-300 px-3 py-1.5 rounded-xl text-xs font-mono">Android Studio</span>
                                <span class="bg-obsidian border border-borderSubtle text-gray-300 px-3 py-1.5 rounded-xl text-xs font-mono">IntelliJ IDEA</span>
                                <span class="bg-obsidian border border-borderSubtle text-gray-300 px-3 py-1.5 rounded-xl text-xs font-mono">Bloodshed Dev-C++</span>
                                <span class="bg-obsidian border border-borderSubtle text-gray-300 px-3 py-1.5 rounded-xl text-xs font-mono">Figma</span>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-xs font-mono text-neonRed uppercase font-bold tracking-wider mb-4">Programming Languages & Frameworks</h4>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 w-full">
                                <div class="flex flex-col items-center justify-center gap-2 bg-obsidian border border-borderSubtle text-purple-300 px-4 py-3 rounded-xl text-xs font-mono shadow-lg hover:border-purple-400 transition text-center group">
                                    <i class="fa-brands fa-laravel text-purple-400 text-xl group-hover:scale-110 transition"></i>
                                    <span class="font-bold text-gray-200 text-xs">Blade</span>
                                    <span class="text-gray-400 text-[10px] leading-tight line-clamp-1">Laravel Engine</span>
                                </div>
                                <div class="flex flex-col items-center justify-center gap-2 bg-obsidian border border-borderSubtle text-amber-300 px-4 py-3 rounded-xl text-xs font-mono shadow-lg hover:border-amber-400 transition text-center group">
                                    <i class="fa-brands fa-php text-amber-400 text-xl group-hover:scale-110 transition"></i>
                                    <span class="font-bold text-gray-200 text-xs">PHP</span>
                                    <span class="text-gray-400 text-[10px] leading-tight line-clamp-1">Backend Web</span>
                                </div>
                                <div class="flex flex-col items-center justify-center gap-2 bg-obsidian border border-borderSubtle text-yellow-300 px-4 py-3 rounded-xl text-xs font-mono shadow-lg hover:border-yellow-400 transition text-center group">
                                    <i class="fa-brands fa-js text-yellow-400 text-xl group-hover:scale-110 transition"></i>
                                    <span class="font-bold text-gray-200 text-xs">JavaScript</span>
                                    <span class="text-gray-400 text-[10px] leading-tight line-clamp-1">Interactive Web</span>
                                </div>
                                <div class="flex flex-col items-center justify-center gap-2 bg-obsidian border border-borderSubtle text-orange-300 px-4 py-3 rounded-xl text-xs font-mono shadow-lg hover:border-orange-400 transition text-center group">
                                    <i class="fa-brands fa-html5 text-orange-400 text-xl group-hover:scale-110 transition"></i>
                                    <span class="font-bold text-gray-200 text-xs">HTML</span>
                                    <span class="text-gray-400 text-[10px] leading-tight line-clamp-1">Semantic Markup</span>
                                </div>
                                <div class="flex flex-col items-center justify-center gap-2 bg-obsidian border border-borderSubtle text-blue-300 px-4 py-3 rounded-xl text-xs font-mono shadow-lg hover:border-blue-400 transition text-center group">
                                    <i class="fa-brands fa-css3-alt text-blue-400 text-xl group-hover:scale-110 transition"></i>
                                    <span class="font-bold text-gray-200 text-xs">CSS</span>
                                    <span class="text-gray-400 text-[10px] leading-tight line-clamp-1">Responsive Design</span>
                                </div>
                                <div class="flex flex-col items-center justify-center gap-2 bg-obsidian border border-borderSubtle text-purple-300 px-4 py-3 rounded-xl text-xs font-mono shadow-lg hover:border-purple-400 transition text-center group">
                                    <i class="fa-brands fa-android text-purple-400 text-xl group-hover:scale-110 transition"></i>
                                    <span class="font-bold text-gray-200 text-xs">Kotlin</span>
                                    <span class="text-gray-400 text-[10px] leading-tight line-clamp-1">Android Mobile</span>
                                </div>
                                <div class="flex flex-col items-center justify-center gap-2 bg-obsidian border border-borderSubtle text-emerald-300 px-4 py-3 rounded-xl text-xs font-mono shadow-lg hover:border-emerald-400 transition text-center group">
                                    <i class="fa-solid fa-cube text-emerald-400 text-xl group-hover:scale-110 transition"></i>
                                    <span class="font-bold text-gray-200 text-xs">C#</span>
                                    <span class="text-gray-400 text-[10px] leading-tight line-clamp-1">Unity Game Dev</span>
                                </div>
                                <div class="flex flex-col items-center justify-center gap-2 bg-obsidian border border-borderSubtle text-red-300 px-4 py-3 rounded-xl text-xs font-mono shadow-lg hover:border-red-400 transition text-center group">
                                    <i class="fa-brands fa-java text-red-400 text-xl group-hover:scale-110 transition"></i>
                                    <span class="font-bold text-gray-200 text-xs">Java</span>
                                    <span class="text-gray-400 text-[10px] leading-tight line-clamp-1">Desktop & Game</span>
                                </div>
                                <div class="flex flex-col items-center justify-center gap-2 bg-obsidian border border-borderSubtle text-cyan-300 px-4 py-3 rounded-xl text-xs font-mono shadow-lg hover:border-cyan-400 transition text-center group">
                                    <i class="fa-solid fa-code text-cyan-400 text-xl group-hover:scale-110 transition"></i>
                                    <span class="font-bold text-gray-200 text-xs">C++</span>
                                    <span class="text-gray-400 text-[10px] leading-tight line-clamp-1">Algorithms</span>
                                </div>
                            </div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', () => {
                                const slider = document.getElementById('programmingCarousel');
                                if (!slider) return;

                                let isDown = false;
                                let startX = 0;
                                let scrollLeft = 0;

                                slider.addEventListener('pointerdown', (e) => {
                                    isDown = true;
                                    slider.classList.add('is-dragging');

                                    startX = e.clientX;
                                    scrollLeft = slider.scrollLeft;

                                    try {
                                        slider.setPointerCapture(e.pointerId);
                                    } catch (err) {}
                                });

                                slider.addEventListener('pointermove', (e) => {
                                    if (!isDown) return;

                                    e.preventDefault();

                                    const walk = (e.clientX - startX) * 1.5;
                                    slider.scrollLeft = scrollLeft - walk;
                                });

                                slider.addEventListener('pointerup', (e) => {
                                    isDown = false;
                                    slider.classList.remove('is-dragging');

                                    try {
                                        if (slider.hasPointerCapture(e.pointerId)) {
                                            slider.releasePointerCapture(e.pointerId);
                                        }
                                    } catch (err) {}
                                });

                                slider.addEventListener('pointercancel', () => {
                                    isDown = false;
                                    slider.classList.remove('is-dragging');
                                });

                                slider.addEventListener('pointerleave', () => {
                                    if (!isDown) {
                                        slider.classList.remove('is-dragging');
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- MUSIC PRODUCTION & ACOUSTIC LAB -->
    <section id="music-production" class="py-28 bg-panel border-y border-borderSubtle scroll-section">
        <div class="max-w-7xl mx-auto px-6 space-y-16">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <span class="text-xs font-mono uppercase tracking-widest text-amber-400 bg-amber-400/10 px-4 py-1.5 rounded-full border border-amber-400/20">Creative Passion // Audio Lab</span>
                    <h2 class="text-4xl font-black text-white mt-4">FL Studio & Acoustic Guitar Craft</h2>
                    <p class="text-gray-400 text-sm mt-2 font-light max-w-xl">Eksplorasi produksi musik digital, beatmaking DAW FL Studio, dan komposisi instrumen gitar akustik & elektrik.</p>
                </div>
                <div class="text-xs font-mono text-gray-400 glass-card px-4 py-2 rounded-xl border border-borderSubtle flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span> DAW Workflow & String Acoustics
                </div>
            </div>

            <!-- FL Studio Feature Section (Centered Layout) -->
            <div class="glass-card rounded-3xl p-8 lg:p-12 border border-borderSubtle shadow-2xl space-y-8 relative overflow-hidden">
                <div class="absolute -right-20 -top-20 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
                
                <div class="text-center max-w-2xl mx-auto space-y-3">
                    <span class="text-xs font-mono text-amber-400 uppercase font-bold tracking-widest">Digital Audio Workstation</span>
                    <h3 class="text-3xl font-black text-white">FL Studio Beatmaking & Mixing Suite</h3>
                    <p class="text-gray-400 text-sm font-light">Workflow produksi musik profesional mulai dari penulisan melodi MIDI, aransemen instrumen virtual VSTi, mixing, hingga mastering final track.</p>
                </div>

                <!-- Centered FL Studio Screenshot Preview -->
                <div class="max-w-4xl mx-auto bg-obsidian border border-borderSubtle rounded-2xl overflow-hidden shadow-2xl group hover:border-amber-400/50 transition duration-500">
                    <div class="bg-zinc-950 px-4 py-3 border-b border-borderSubtle flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="w-3 h-3 rounded-full bg-red-500/80 inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-yellow-500/80 inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-green-500/80 inline-block"></span>
                            <span class="text-xs font-mono text-gray-400 ml-2">FL Studio 24 - Workspace Project Session</span>
                        </div>
                        <span class="text-[10px] font-mono text-amber-400 bg-amber-400/10 px-2.5 py-1 rounded border border-amber-400/20">DAW Active</span>
                    </div>
                    <div class="p-2 sm:p-4 bg-black flex justify-center items-center">
                        <img src="{{ asset('images/music/fl-studio.png') }}" alt="FL Studio Workspace" class="w-full h-auto rounded-xl shadow-lg object-contain max-h-[550px] group-hover:scale-[1.01] transition duration-500">
                    </div>
                    <div class="bg-zinc-950 px-6 py-4 border-t border-borderSubtle flex flex-wrap items-center justify-between gap-4 text-xs font-mono text-gray-400">
                        <span class="flex items-center gap-2"><i class="fa-solid fa-sliders text-amber-400"></i> Playlist & Mixer Routing</span>
                        <span class="text-amber-400">Plugin VSTi & Automation Clips</span>
                    </div>
                </div>
            </div>

            <!-- Guitar Collection Section -->
            <div class="space-y-8">
                <div class="text-center max-w-2xl mx-auto space-y-3">
                    <span class="text-xs font-mono text-amber-400 uppercase font-bold tracking-widest">Acoustic & Electric Gear</span>
                    <h3 class="text-3xl font-black text-white">Guitar Instruments & Gear Arsenal</h3>
                    <p class="text-gray-400 text-sm font-light">Koleksi instrumen gitar andalan yang digunakan untuk rekaman melodi live, fingerstyle, dan harmoni ritmis.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Guitar 1 -->
                    <div class="glass-card rounded-3xl p-6 lg:p-8 border border-borderSubtle shadow-2xl flex flex-col justify-between space-y-6 group hover:border-amber-400/50 transition duration-500">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-mono text-amber-400 font-bold uppercase">Instrument 01</span>
                                <span class="text-[10px] font-mono bg-obsidian text-gray-300 px-2.5 py-1 rounded border border-borderSubtle">Acoustic / Electric Setup</span>
                            </div>
                            <h4 class="text-xl font-bold text-white">Primary Performance Guitar</h4>
                            <p class="text-xs text-gray-400 font-light">Instrumen utama dengan resonansi akustik jernih dan pickup berkualitas tinggi untuk rekaman langsung di studio.</p>
                        </div>
                        <div class="bg-obsidian border border-borderSubtle rounded-2xl overflow-hidden p-3 flex justify-center items-center">
                            <img src="{{ asset('images/music/guitar-1.jpg') }}" alt="Guitar Model 1" class="w-full h-[320px] object-cover rounded-xl group-hover:scale-105 transition duration-500">
                        </div>
                    </div>

                    <!-- Guitar 2 -->
                    <div class="glass-card rounded-3xl p-6 lg:p-8 border border-borderSubtle shadow-2xl flex flex-col justify-between space-y-6 group hover:border-amber-400/50 transition duration-500">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-mono text-amber-400 font-bold uppercase">Instrument 02</span>
                                <span class="text-[10px] font-mono bg-obsidian text-gray-300 px-2.5 py-1 rounded border border-borderSubtle">Acoustic Precision</span>
                            </div>
                            <h4 class="text-xl font-bold text-white">Acoustic Craft & Fingerstyle Guitar</h4>
                            <p class="text-xs text-gray-400 font-light">Gitar akustik bersuara hangat, ideal untuk aransemen chord kompleks dan rekaman musik akustik bernuansa natural.</p>
                        </div>
                        <div class="bg-obsidian border border-borderSubtle rounded-2xl overflow-hidden p-3 flex justify-center items-center">
                            <img src="{{ asset('images/music/guitar-2.jpg') }}" alt="Guitar Model 2" class="w-full h-[320px] object-cover rounded-xl group-hover:scale-105 transition duration-500">
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
                            <span class="text-xs font-mono text-neonRed uppercase font-bold">Model 01 // Neo-Cyber Formula</span>
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
                <div class="bg-zinc-950 px-4 sm:px-6 py-3 border-b border-borderSubtle flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center space-x-3 overflow-x-auto pb-1 md:pb-0">
                        <div class="flex items-center space-x-2 shrink-0">
                            <span class="w-3 h-3 rounded-full bg-red-500 inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-yellow-500 inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-green-500 inline-block"></span>
                        </div>
                        <div class="h-4 w-[1px] bg-borderSubtle shrink-0"></div>
                        <div class="flex items-center space-x-2 text-xs font-mono text-gray-300 shrink-0">
                            <i class="fa-brands fa-figma text-indigo-400 text-sm"></i>
                            <span class="font-bold text-white truncate max-w-[200px] sm:max-w-none">Farrel Balapradhana — UI/UX Master Workspace</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 shrink-0">
                        <span class="text-[10px] font-mono bg-indigo-600/20 text-indigo-400 px-3 py-1 rounded border border-indigo-500/35">Live Sync</span>
                        <a href="https://www.figma.com" target="_blank" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-1.5 rounded-xl text-xs font-mono font-bold transition flex items-center space-x-2 shrink-0">
                            <span>Open in Figma</span>
                            <i class="fa-solid fa-external-link-alt text-[10px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Figma Canvas Body -->
                <div class="grid grid-cols-1 lg:grid-cols-4 min-h-[500px]">
                    <!-- Left Layers Sidebar (Collapsible / Responsive) -->
                    <div class="bg-zinc-950/70 border-b lg:border-b-0 lg:border-r border-borderSubtle p-4 space-y-4 text-xs font-mono text-gray-400">
                        <div class="text-[10px] uppercase text-gray-500 font-bold tracking-widest px-2 flex justify-between items-center">
                            <span>Layers & Frames</span>
                            <span class="text-indigo-400 text-[9px] lg:hidden">Active</span>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-1 gap-1.5">
                            <div class="flex items-center space-x-2 px-3 py-2 rounded-xl bg-indigo-600/15 text-indigo-400 border border-indigo-500/30 truncate">
                                <i class="fa-solid fa-mobile-screen shrink-0"></i>
                                <span class="truncate">📱 Mobile App Prototype</span>
                            </div>
                            <div class="flex items-center space-x-2 px-3 py-2 rounded-xl hover:bg-borderSubtle transition text-gray-300 truncate">
                                <i class="fa-solid fa-desktop shrink-0"></i>
                                <span class="truncate">💻 Web Dashboard UI</span>
                            </div>
                            <div class="flex items-center space-x-2 px-3 py-2 rounded-xl hover:bg-borderSubtle transition text-gray-300 truncate">
                                <i class="fa-solid fa-layer-group shrink-0"></i>
                                <span class="truncate">🎨 Design System Tokens</span>
                            </div>
                            <div class="flex items-center space-x-2 px-3 py-2 rounded-xl hover:bg-borderSubtle transition text-gray-300 truncate">
                                <i class="fa-solid fa-shapes shrink-0"></i>
                                <span class="truncate">🧩 Component Library</span>
                            </div>
                        </div>

                        <div class="pt-4 lg:pt-6 border-t border-borderSubtle hidden sm:block">
                            <div class="text-[10px] uppercase text-gray-500 font-bold tracking-widest px-2 mb-2">Properties</div>
                            <div class="grid grid-cols-3 lg:grid-cols-1 gap-2 text-[11px] text-gray-300 px-2">
                                <div class="flex justify-between lg:justify-between"><span>Fill:</span> <span class="text-indigo-400 font-mono">#0B0B0F</span></div>
                                <div class="flex justify-between lg:justify-between"><span>Auto Layout:</span> <span class="text-green-400 font-mono">Enabled</span></div>
                                <div class="flex justify-between lg:justify-between"><span>Spacing:</span> <span class="text-gray-400 font-mono">24px</span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Center Main Canvas (Figma Embed / Interactive Prototype) -->
                    <div class="lg:col-span-3 relative bg-darkBg flex flex-col items-center justify-center p-4">
                        @php
                            $uiUxProject = $projects->first(fn($p) => strtolower($p->category ?? '') === 'ui/ux design');
                        @endphp

                        @if($uiUxProject)
                        <div class="w-full h-[400px] sm:h-[500px] md:h-[580px] rounded-2xl overflow-hidden border border-borderSubtle shadow-2xl relative bg-zinc-950">
                            <iframe 
                                src="https://embed.figma.com/design/ECZYip7e5fJ2CmwQErWxoA/Aplikasi-GoMuncak-320-321?node-id=0-1&embed-host=share" 
                                allowfullscreen 
                                class="w-full h-full border-0">
                            </iframe>
                        </div>
                        <div class="mt-4 flex flex-col sm:flex-row items-center justify-between w-full px-2 gap-2 text-xs font-mono text-gray-400">
                            <span class="truncate">Active Frame: <strong class="text-white">{{ $uiUxProject->title }}</strong> (UI/UX Design Only)</span>
                            <a href="https://www.com" target="_blank" class="text-indigo-400 hover:underline shrink-0">Buka Fullscreen Prototype →</a>
                        </div>
                        @else
                        <div class="text-center p-12 space-y-4">
                            <i class="fa-brands fa-figma text-5xl text-indigo-500"></i>
                            <p class="text-gray-300 font-mono text-sm">Prototype Figma khusus untuk project UI/UX Design.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- GITHUB LIVE REPO / CONTRIBUTIONS HUB -->
    <section id="github-hub" class="py-28 bg-panel border-y border-borderSubtle scroll-section relative z-10">
        <div class="max-w-7xl mx-auto px-6 space-y-12">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <span class="text-xs font-mono uppercase tracking-widest text-neonRed bg-neonRed/10 px-4 py-1.5 rounded-full border border-neonRed/20">Open Source Hub</span>
                    <h2 class="text-4xl font-black text-white mt-4">Live GitHub Activity & Repositories</h2>
                    <p class="text-gray-400 text-sm mt-2 font-light max-w-xl">Eksplorasi langsung repositori publik, aktivitas commit, dan kontribusi open-source dari akun GitHub saya.</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-xs font-mono text-gray-400">GitHub Profile:</span>
                    <a href="https://github.com/farrelzzzzzzz" target="_blank" class="bg-neonRed/20 text-neonRed px-4 py-2 rounded-xl text-xs font-mono font-bold border border-neonRed/30 hover:bg-neonRed hover:text-white transition flex items-center space-x-2 shadow-lg shadow-neonGlow">
                        <i class="fa-brands fa-github text-sm"></i>
                        <span>@farrelzzzzzzz</span>
                    </a>
                </div>
            </div>

            <!-- GitHub Live Card / Embed Hub -->
            <div class="glass-card rounded-3xl border border-borderSubtle shadow-2xl overflow-hidden bg-obsidian p-6 sm:p-8 space-y-8">
                <!-- Top GitHub Toolbar -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pb-6 border-b border-borderSubtle">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-2xl glass-card flex items-center justify-center border border-neonRed/40 text-neonRed text-xl shadow-lg">
                            <i class="fa-brands fa-github"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Farrel Balapradhana GitHub Feed</h3>
                            <p class="text-xs font-mono text-gray-400 mt-0.5">Real-time repository sync & open source codebase.</p>
                        </div>
                    </div>
                    <a href="https://github.com/farrelzzzzzzz?tab=repositories" target="_blank" class="bg-obsidian hover:bg-borderSubtle text-gray-300 hover:text-white px-5 py-2.5 rounded-xl text-xs font-mono font-bold uppercase tracking-wider border border-borderSubtle transition flex items-center space-x-2">
                        <span>View All Repositories</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                </div>

                <!-- GitHub Widget / Readme Stats Embed -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Profile Stats -->
                    <div class="glass-card rounded-2xl p-6 border border-borderSubtle flex flex-col justify-between space-y-4 hover:border-neonRed transition">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-mono text-neonRed font-bold uppercase">Contributions</span>
                            <i class="fa-solid fa-chart-line text-gray-400"></i>
                        </div>
                        <div class="space-y-2">
                            <h4 class="text-lg font-bold text-white">Activity Graph & Streak</h4>
                            <p class="text-xs text-gray-400 font-light">Visualisasi kontribusi commit harian pada project portofolio dan web development.</p>
                        </div>
                        <div class="pt-4 border-t border-borderSubtle">
                            <a href="https://github.com/farrelzzzzzzz" target="_blank" class="text-xs font-mono text-neonRed hover:underline font-bold">Check GitHub Profile →</a>
                        </div>
                    </div>

                    <!-- Pinned Repos / Embed Preview Area -->
                    <div class="lg:col-span-2 glass-card rounded-2xl p-6 border border-borderSubtle space-y-4 relative overflow-hidden flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-mono text-indigo-400 font-bold uppercase">Live GitHub Repositories</span>
                            <span class="text-[10px] font-mono text-emerald-400 bg-obsidian px-2 py-1 rounded border border-borderSubtle flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span> Live Sync
                            </span>
                        </div>
                        
                        <!-- Direct GitHub Repos Grid Preview -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <a href="https://github.com/farrelzzzzzzz/portofolio-web" target="_blank" class="bg-obsidian border border-borderSubtle hover:border-neonRed p-4 rounded-xl transition group flex flex-col justify-between space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-white text-sm group-hover:text-neonRed transition flex items-center gap-2">
                                        <i class="fa-solid fa-book-bookmark text-neonRed text-xs"></i> portofolio-web
                                    </span>
                                    <span class="text-[10px] font-mono bg-borderSubtle text-gray-300 px-2 py-0.5 rounded">Public</span>
                                </div>
                                <p class="text-xs text-gray-400 font-light line-clamp-2">High-end UI/UX & 3D Creative Portfolio website built on Laravel 11, Tailwind, and Three.js.</p>
                                <div class="flex items-center justify-between text-[10px] font-mono text-gray-500 pt-2 border-t border-borderSubtle/50">
                                    <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-yellow-400"></span> PHP / Blade</span>
                                    <span>Updated Live</span>
                                </div>
                            </a>

                            <a href="https://github.com/farrelzzzzzzz?tab=repositories" target="_blank" class="bg-obsidian border border-borderSubtle hover:border-neonRed p-4 rounded-xl transition group flex flex-col justify-center items-center text-center space-y-2">
                                <div class="w-10 h-10 rounded-full bg-neonRed/10 border border-neonRed/30 flex items-center justify-center text-neonRed group-hover:scale-110 transition">
                                    <i class="fa-brands fa-github text-lg"></i>
                                </div>
                                <span class="font-bold text-white text-xs">Explore All Repositories on GitHub</span>
                                <span class="text-[10px] font-mono text-gray-400">github.com/farrelzzzzzzz</span>
                            </a>
                        </div>

                        <div class="flex flex-wrap items-center gap-3 pt-2">
                            <span class="text-[10px] font-mono bg-obsidian text-yellow-400 px-3 py-1 rounded border border-borderSubtle">⚡ PHP / Blade</span>
                            <span class="text-[10px] font-mono bg-obsidian text-blue-400 px-3 py-1 rounded border border-borderSubtle">🎨 Tailwind CSS</span>
                            <span class="text-[10px] font-mono bg-obsidian text-neonRed px-3 py-1 rounded border border-borderSubtle">🧊 Three.js</span>
                            <a href="https://github.com/farrelzzzzzzz?tab=repositories" target="_blank" class="ml-auto bg-neonRed hover:bg-red-600 text-white px-4 py-2 rounded-xl text-xs font-mono font-bold transition flex items-center space-x-2 shadow-lg shadow-neonGlow">
                                <span>View All on GitHub</span>
                                <i class="fa-brands fa-github text-xs"></i>
                            </a>
                        </div>
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

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 lg:gap-12">
                
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

                    <div class="relative w-full h-[320px] sm:h-[400px] md:h-[440px] bg-obsidian border border-borderSubtle rounded-2xl overflow-hidden flex items-center justify-center p-4 cursor-pointer" onclick="nextPage1()">
                        <div class="relative w-full h-full max-w-lg book-container flex items-center justify-center" id="m1-book">
                            @php
                                $m1Pages = [
                                    ['cover', 'bg-gradient-to-br from-emerald-700 via-teal-800 to-black', 'text-emerald-300', 'ISSUE #12', 'Architecture & Nature', 'Click to Open →', ''],
                                    ['page', 'bg-gradient-to-br from-emerald-900/40 to-zinc-900', 'text-emerald-400', "PAGE 01", "Editor's Note", 'Selamat datang di edisi khusus yang membahas masa depan perancangan kota berkelanjutan.', '01'],
                                    ['page', 'bg-gradient-to-br from-teal-900/40 to-zinc-900', 'text-teal-400', "PAGE 02", "Urban Ecology", 'Integrasi tanaman vertikal pada fasad gedung tinggi mengurangi suhu kota secara drastis.', '02'],
                                    ['page', 'bg-gradient-to-br from-emerald-900/40 to-zinc-900', 'text-emerald-400', "PAGE 03", "Biophilic Design", 'Penerapan elemen alam ke dalam arsitektur untuk meningkatkan kualitas hidup penghuni.', '03'],
                                    ['page', 'bg-gradient-to-br from-teal-900/40 to-zinc-900', 'text-teal-400', "PAGE 04", "Green Facades", 'Sistem fasad hidup yang menggabungkan estetika, isolasi termal, dan biodiversitas.', '04'],
                                    ['page', 'bg-gradient-to-br from-emerald-900/40 to-zinc-900', 'text-emerald-400', "PAGE 05", "Urban Forests", 'Inisiatif reboisasi kota metropolitan sebagai paru-paru kolektif.', '05'],
                                    ['page', 'bg-gradient-to-br from-teal-900/40 to-zinc-900', 'text-teal-400', "PAGE 06", "Smart Cities", 'Sensor dan AI untuk tata kelola kota yang lebih efisien dan berkelanjutan.', '06'],
                                    ['page', 'bg-gradient-to-br from-emerald-900/40 to-zinc-900', 'text-emerald-400', "PAGE 07", "Renewable Energy", 'Panel surya terintegrasi fasad sebagai sumber energi gedung pintar.', '07'],
                                    ['page', 'bg-gradient-to-br from-teal-900/40 to-zinc-900', 'text-teal-400', "PAGE 08", "Net Zero Buildings", 'Standar konstruksi modern dengan jejak karbon nol.', '08'],
                                    ['page', 'bg-gradient-to-br from-emerald-900/40 to-zinc-900', 'text-emerald-400', "PAGE 09", "Passive Cooling", 'Teknik ventilasi silang dan shading untuk efisiensi energi.', '09'],
                                    ['page', 'bg-gradient-to-br from-teal-900/40 to-zinc-900', 'text-teal-400', "PAGE 10", "Sustainable Materials", 'Beton rendah karbon, bambu laminated, dan mycelium insulation.', '10'],
                                    ['page', 'bg-gradient-to-br from-emerald-900/40 to-zinc-900', 'text-emerald-400', "PAGE 11", "Adaptive Reuse", 'Konversi bangunan lama menjadi ruang fungsional baru tanpa pembongkaran total.', '11'],
                                    ['page', 'bg-gradient-to-br from-teal-900/40 to-zinc-900', 'text-teal-400', "PAGE 12", "Modular Construction", 'Sistem prefabrikasi yang mempercepat pembangunan dan mengurangi limbah.', '12'],
                                    ['page', 'bg-gradient-to-br from-emerald-900/40 to-zinc-900', 'text-emerald-400', "PAGE 13", "Daylight Harvesting", 'Optimalisasi pencahayaan alami untuk mengurangi konsumsi listrik.', '13'],
                                    ['page', 'bg-gradient-to-br from-teal-900/40 to-zinc-900', 'text-teal-400', "PAGE 14", "Water Sensitive Design", 'Manajemen air hujan terintegrasi pada lansekap perkotaan.', '14'],
                                    ['page', 'bg-gradient-to-br from-emerald-900/40 to-zinc-900', 'text-emerald-400', "PAGE 15", "Resilient Infrastructure", "Bangunan tahan bencana sebagai tulang punggung komunitas.", '15'],
                                    ['page', 'bg-gradient-to-br from-teal-900/40 to-zinc-900', 'text-teal-400', "PAGE 16", "Transit Oriented Dev", 'Pusat kota yang dirancang di simpul transportasi publik.', '16'],
                                    ['page', 'bg-gradient-to-br from-emerald-900/40 to-zinc-900', 'text-emerald-400', "PAGE 17", "Mixed Use Spaces", "Integrasi residensial, komersial, dan ruang publik dalam satu kawasan.", '17'],
                                    ['page', 'bg-gradient-to-br from-teal-900/40 to-zinc-900', 'text-teal-400', "PAGE 18", "Vertical Farming", "Pertanian vertikal dalam gedung sebagai sumber pangan lokal.", '18'],
                                    ['page', 'bg-gradient-to-br from-emerald-900/40 to-zinc-900', 'text-emerald-400', "PAGE 19", "Acoustic Comfort", "Material dan tata ruang untuk mengendalikan kebisingan urban.", '19'],
                                    ['page', 'bg-gradient-to-br from-teal-900/40 to-zinc-900', 'text-teal-400', "PAGE 20", "Microclimate Design", "Pengaruh bayangan, angin, dan vegetasi terhadap kenyamanan termal.", '20'],
                                    ['page', 'bg-gradient-to-br from-emerald-900/40 to-zinc-900', 'text-emerald-400', "PAGE 21", "Heritage Conservation", "Pelestarian situs bersejarah dalam konteks modernisasi.", '21'],
                                    ['page', 'bg-gradient-to-br from-teal-900/40 to-zinc-900', 'text-teal-400', "PAGE 22", "Parametric Architecture", "Algoritma generatif untuk desain struktural yang presisi.", '22'],
                                    ['page', 'bg-gradient-to-br from-emerald-900/40 to-zinc-900', 'text-emerald-400', "PAGE 23", "Robotic Construction", "Otomatisasi konstruksi dengan lengan robot presisi tinggi.", '23'],
                                    ['page', 'bg-gradient-to-br from-teal-900/40 to-zinc-900', 'text-teal-400', "PAGE 24", "Digital Twins", "Replika digital gedung untuk simulasi dan pemeliharaan prediktif.", '24'],
                                    ['page', 'bg-gradient-to-br from-emerald-900/40 to-zinc-900', 'text-emerald-400', "PAGE 25", "AI Space Planning", "Kecerdasan buatan dalam optimalisasi tata ruang.", '25'],
                                    ['page', 'bg-gradient-to-br from-teal-900/40 to-zinc-900', 'text-teal-400', "PAGE 26", "IoT in Buildings", "Sensor terhubung untuk manajemen gedung secara real-time.", '26'],
                                    ['page', 'bg-gradient-to-br from-emerald-900/40 to-zinc-900', 'text-emerald-400', "PAGE 27", "Wellbeing Architecture", "Desain yang memprioritaskan kesehatan fisik dan mental pengguna.", '27'],
                                    ['page', 'bg-gradient-to-br from-teal-900/40 to-zinc-900', 'text-teal-400', "PAGE 28", "Circular Economy", "Siklus material tertutup dalam industri konstruksi.", '28'],
                                    ['page', 'bg-gradient-to-br from-emerald-900/40 to-zinc-900', 'text-emerald-400', "PAGE 29", "Future Horizons", "Eksplorasi material bio-komposit dan arsitektur regeneratif untuk dekade mendatang.", '29'],
                                    ['page', 'bg-gradient-to-br from-teal-900/40 to-zinc-900', 'text-teal-400', "PAGE 30", "Closing Notes", "Visi kolaboratif antara arsitek,工程师, dan masyarakat untuk masa depan yang lestari.", '30'],
                                    ['back', 'bg-gradient-to-br from-black via-zinc-900 to-emerald-950', 'text-emerald-300', 'BACK COVER', 'Cagar Publications', '© 2026', '30'],
                                ];
                                $m1Count = count($m1Pages);
                            @endphp
                            @for($i = 0; $i < $m1Count; $i += 2)
                                @php
                                    $p1 = $m1Pages[$i];
                                    $p2 = $m1Pages[$i + 1];
                                    $sheetIdx = ($i / 2) + 1;
                                    $z = 30 - (int)($i / 2);
                                @endphp
                                <div id="m1-sheet-{{ $sheetIdx }}" class="book-sheet absolute right-0 w-1/2 h-full" style="z-index: {{ $z }};">
                                    <div class="book-face {{ $p1[1] }} border-r border-borderSubtle p-6 flex flex-col justify-between">
                                        <div>
                                            <span class="text-[10px] font-mono {{ $p1[2] }} uppercase font-bold">{{ $p1[3] }}</span>
                                            <h4 class="text-lg font-bold text-white mt-2">{{ $p1[4] }}</h4>
                                            @if($p1[5] !== '')<p class="text-gray-200 text-xs mt-2 font-light">{{ $p1[5] }}</p>@endif
                                        </div>
                                        @if($p1[6] !== '')<span class="text-[10px] font-mono text-gray-500">{{ $p1[6] }}</span>@endif
                                    </div>
                                    <div class="book-face book-face-back {{ $p2[1] }} border-l border-borderSubtle p-6 flex flex-col justify-between">
                                        <div>
                                            <span class="text-[10px] font-mono {{ $p2[2] }} uppercase font-bold">{{ $p2[3] }}</span>
                                            <h4 class="text-lg font-bold text-white mt-2">{{ $p2[4] }}</h4>
                                            @if($p2[5] !== '')<p class="text-gray-200 text-xs mt-2 font-light">{{ $p2[5] }}</p>@endif
                                        </div>
                                        @if($p2[6] !== '')<span class="text-[10px] font-mono text-gray-500">{{ $p2[6] }}</span>@endif
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Magazine 2 -->
                <div class="glass-card rounded-3xl p-8 border border-borderSubtle shadow-2xl space-y-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-xs font-mono text-neonRed uppercase font-bold">Publication #02</span>
                            <h3 class="text-2xl font-bold text-white mt-1">Guitar Craft & Acoustics Mag</h3>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button onclick="prevPage2()" class="glass-card px-3 py-1.5 rounded-xl text-xs font-mono text-white border border-borderSubtle hover:bg-borderSubtle">Prev</button>
                            <span id="page-indicator-2" class="text-xs font-mono text-gray-400 px-2">Cover</span>
                            <button onclick="nextPage2()" class="bg-neonRed text-white px-3 py-1.5 rounded-xl text-xs font-mono font-bold">Next</button>
                        </div>
                    </div>

                    <div class="relative w-full h-[320px] sm:h-[400px] md:h-[440px] bg-obsidian border border-borderSubtle rounded-2xl overflow-hidden flex items-center justify-center p-4 cursor-pointer" onclick="nextPage2()">
                        <div class="relative w-full h-full max-w-lg book-container flex items-center justify-center" id="m2-book">
                            @php
                                $m2Pages = [
                                    ['cover', 'bg-gradient-to-br from-amber-600 via-orange-700 to-black', 'text-amber-300', 'ISSUE #08', 'The Art of Guitar', 'Click to Open →', ''],
                                    ['page', 'bg-gradient-to-br from-amber-900/40 to-zinc-900', 'text-amber-400', "PAGE 01", "Master Luthier", 'Eksplorasi teknik pengerjaan fretboard kustom dan kalibrasi pickup elektrik.', '01'],
                                    ['page', 'bg-gradient-to-br from-orange-900/40 to-zinc-900', 'text-orange-400', "PAGE 02", "Tone & Woods", 'Pemilihan kayu Adirondack spruce dan mahogany untuk resonansi akustik terbaik.', '02'],
                                    ['page', 'bg-gradient-to-br from-amber-900/40 to-zinc-900', 'text-amber-400', "PAGE 03", "Neck Profiles", 'Perbedaan profil neck C, V, dan U untuk ergonomi pemain.', '03'],
                                    ['page', 'bg-gradient-to-br from-orange-900/40 to-zinc-900', 'text-orange-400', "PAGE 04", "Fretwire Mastery", 'Pemilihan ukuran fretwire (jumbo, vintage, medium) untuk playability.', '04'],
                                    ['page', 'bg-gradient-to-br from-amber-900/40 to-zinc-900', 'text-amber-400', "PAGE 05", "Pickup Science", 'Single coil, humbucker, dan P90 dalam karakter sonic yang berbeda.', '05'],
                                    ['page', 'bg-gradient-to-br from-orange-900/40 to-zinc-900', 'text-orange-400', "PAGE 06", "Brass vs Aluminum", 'Material saddle dan nut yang memengaruhi sustain dan timbre.', '06'],
                                    ['page', 'bg-gradient-to-br from-amber-900/40 to-zinc-900', 'text-amber-400', "PAGE 07", "Bolt-on vs Set-neck", 'Perbedaan konstruksi neck joint dalam sustain dan resonansi.', '07'],
                                    ['page', 'bg-gradient-to-br from-orange-900/40 to-zinc-900', 'text-orange-400', "PAGE 08", "Acoustic Bracing", 'Pola X-bracing scalloped untuk proyeksi suara akustik.', '08'],
                                    ['page', 'bg-gradient-to-br from-amber-900/40 to-zinc-900', 'text-amber-400', "PAGE 09", "Finish & Lacquer", 'Nitrocellulose vs polyurethane dalam hal aging dan tone.', '09'],
                                    ['page', 'bg-gradient-to-br from-orange-900/40 to-zinc-900', 'text-orange-400', "PAGE 10", "Intonation Tuning", 'Setting saddle position untuk akurasi nada di semua fret.', '10'],
                                    ['page', 'bg-gradient-to-br from-amber-900/40 to-zinc-900', 'text-amber-400', "PAGE 11", "Tremolo Systems", 'Vintage Bigsby, modern Floyd Rose, dan implikasi nada.', '11'],
                                    ['page', 'bg-gradient-to-br from-orange-900/40 to-zinc-900', 'text-orange-400', "PAGE 12", "String Gauges", 'Perbedaan tension dan tone antara light, regular, dan heavy.', '12'],
                                    ['page', 'bg-gradient-to-br from-amber-900/40 to-zinc-900', 'text-amber-400', "PAGE 13", "Amplifier Pairing", 'Menyesuaikan karakter gitar dengan tube amp dan solid-state.', '13'],
                                    ['page', 'bg-gradient-to-br from-orange-900/40 to-zinc-900', 'text-orange-400', "PAGE 14", "Pedal Crafting", "Membangun overdrive kustom dengan germanium clipping.", '14'],
                                    ['page', 'bg-gradient-to-br from-amber-900/40 to-zinc-900', 'text-amber-400', "PAGE 15", "Recording Mics", "Teknik mikrofon gitar akustik untuk studio berkualitas.", '15'],
                                    ['page', 'bg-gradient-to-br from-orange-900/40 to-zinc-900', 'text-orange-400', "PAGE 16", "Slide Techniques", "Bottleneck, lap steel, dan dobro dalam blues tradition.", '16'],
                                    ['page', 'bg-gradient-to-br from-amber-900/40 to-zinc-900', 'text-amber-400', "PAGE 17", "Fingerstyle Mastery", "Travis picking, percussive, dan hybrid two-handed tapping.", '17'],
                                    ['page', 'bg-gradient-to-br from-orange-900/40 to-zinc-900', 'text-orange-400', "PAGE 18", "Capo Mastery", "Posisi capo untuk modulasi kunci dan timbre.", '18'],
                                    ['page', 'bg-gradient-to-br from-amber-900/40 to-zinc-900', 'text-amber-400', "PAGE 19", "Vintage Restoration", "Meremikan gitar vintage 60an dengan parts original.", '19'],
                                    ['page', 'bg-gradient-to-br from-orange-900/40 to-zinc-900', 'text-orange-400', "PAGE 20", "Relic Finishes", "Teknik aging nitro untuk tampilan road-worn autentik.", '20'],
                                    ['page', 'bg-gradient-to-br from-amber-900/40 to-zinc-900', 'text-amber-400', "PAGE 21", "Boutique Builders", "Profil luthier independen dunia dan signature mereka.", '21'],
                                    ['page', 'bg-gradient-to-br from-orange-900/40 to-zinc-900', 'text-orange-400', "PAGE 22", "7 vs 8 Strings", "Extended range gitar untuk metal progresif modern.", '22'],
                                    ['page', 'bg-gradient-to-br from-amber-900/40 to-zinc-900', 'text-amber-400', "PAGE 23", "Baritone Tuning", "String set dan tension untuk register baritone.", '23'],
                                    ['page', 'bg-gradient-to-br from-orange-900/40 to-zinc-900', 'text-orange-400', "PAGE 24", "Travel Guitars", "Desain kompak tanpa kompromi pada tone.", '24'],
                                    ['page', 'bg-gradient-to-br from-amber-900/40 to-zinc-900', 'text-amber-400', "PAGE 25", "Silent Practice", "Headphone amp dan IR technology untuk latihan senyap.", '25'],
                                    ['page', 'bg-gradient-to-br from-orange-900/40 to-zinc-900', 'text-orange-400', "PAGE 26", "Gig Bags & Cases", "Perlindungan optimal dengan hardcase ATA flight grade.", '26'],
                                    ['page', 'bg-gradient-to-br from-amber-900/40 to-zinc-900', 'text-amber-400', "PAGE 27", "Climate Control", "Humidifier system untuk mencegah crack pada body akustik.", '27'],
                                    ['page', 'bg-gradient-to-br from-orange-900/40 to-zinc-900', 'text-orange-400', "PAGE 28", "Custom Shop", "Proses commissioning gitar custom dari spec sheet.", '28'],
                                    ['page', 'bg-gradient-to-br from-amber-900/40 to-zinc-900', 'text-amber-400', "PAGE 29", "Future of Tone", "AI-assisted wood selection dan CNC precision crafting.", '29'],
                                    ['page', 'bg-gradient-to-br from-orange-900/40 to-zinc-900', 'text-orange-400', "PAGE 30", "Final Chord", "Refleksi dedikasi para luthier dan musisi dalam melestarikan seni gitar.", '30'],
                                    ['back', 'bg-gradient-to-br from-black via-zinc-900 to-amber-950', 'text-amber-300', 'BACK COVER', 'Luthier Guild Press', '© 2026', '30'],
                                ];
                                $m2Count = count($m2Pages);
                            @endphp
                            @for($i = 0; $i < $m2Count; $i += 2)
                                @php
                                    $p1 = $m2Pages[$i];
                                    $p2 = $m2Pages[$i + 1];
                                    $sheetIdx = ($i / 2) + 1;
                                    $z = 30 - (int)($i / 2);
                                @endphp
                                <div id="m2-sheet-{{ $sheetIdx }}" class="book-sheet absolute right-0 w-1/2 h-full" style="z-index: {{ $z }};">
                                    <div class="book-face {{ $p1[1] }} border-r border-borderSubtle p-6 flex flex-col justify-between">
                                        <div>
                                            <span class="text-[10px] font-mono {{ $p1[2] }} uppercase font-bold">{{ $p1[3] }}</span>
                                            <h4 class="text-lg font-bold text-white mt-2">{{ $p1[4] }}</h4>
                                            @if($p1[5] !== '')<p class="text-gray-200 text-xs mt-2 font-light">{{ $p1[5] }}</p>@endif
                                        </div>
                                        @if($p1[6] !== '')<span class="text-[10px] font-mono text-gray-500">{{ $p1[6] }}</span>@endif
                                    </div>
                                    <div class="book-face book-face-back {{ $p2[1] }} border-l border-borderSubtle p-6 flex flex-col justify-between">
                                        <div>
                                            <span class="text-[10px] font-mono {{ $p2[2] }} uppercase font-bold">{{ $p2[3] }}</span>
                                            <h4 class="text-lg font-bold text-white mt-2">{{ $p2[4] }}</h4>
                                            @if($p2[5] !== '')<p class="text-gray-200 text-xs mt-2 font-light">{{ $p2[5] }}</p>@endif
                                        </div>
                                        @if($p2[6] !== '')<span class="text-[10px] font-mono text-gray-500">{{ $p2[6] }}</span>@endif
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ARCHIVE / SELECTED WORKS -->
    <section id="portfolio" class="py-28 border-t border-borderSubtle scroll-section">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                <div>
                    <span class="text-xs font-mono uppercase tracking-widest text-neonRed bg-neonRed/10 px-4 py-1.5 rounded-full border border-neonRed/20">Archive</span>
                    <h2 class="text-4xl font-black text-white mt-4">Selected Works</h2>
                    <p class="text-gray-400 text-sm mt-2 font-light">Kurasi proyek terbaik dan publikasi majalah digital dalam bidang UI/UX, 3D, dan pengembangan web.</p>
                </div>

                <div class="flex flex-wrap gap-2">
                    @php
                        $filterCats = ['All', 'UI/UX Design', 'Graphic Design', '3D Design', 'Animation', 'Web Development', 'Canva', 'Magazine'];
                    @endphp
                    @foreach($filterCats as $fcat)
                    <a href="/?category={{ urlencode($fcat) }}#portfolio" class="px-5 py-3 rounded-2xl text-xs font-mono font-bold uppercase tracking-wider transition duration-300 {{ ($category === $fcat) ? 'bg-neonRed text-white shadow-xl shadow-neonGlow' : 'glass-card text-gray-300 hover:bg-borderSubtle border border-borderSubtle' }}">
                        {{ $fcat }}
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Projects --}}
                @if($category !== 'Magazine')
                @forelse($projects as $project)
                <div class="glass-card border border-borderSubtle rounded-3xl overflow-hidden group hover:border-neonRed transition duration-500 flex flex-col justify-between shadow-2xl hover:-translate-y-2">
                    <div>
                        <div class="relative overflow-hidden aspect-video">
                            @if(!empty($project->canva_url))
                                @php
                                    $canvaEmbedUrl = $project->canva_url;
                                    if (str_contains($canvaEmbedUrl, '/view')) {
                                        $canvaEmbedUrl = rtrim($canvaEmbedUrl, '/') . '?embed';
                                    } elseif (!str_contains($canvaEmbedUrl, 'embed')) {
                                        $canvaEmbedUrl = rtrim($canvaEmbedUrl, '/') . '/view?embed';
                                    }
                                @endphp
                                <div class="w-full h-full bg-obsidian flex flex-col items-center justify-center p-0 relative group/canva">
                                    <iframe src="{{ $canvaEmbedUrl }}" class="w-full h-full border-0 absolute inset-0" allowfullscreen="allowfullscreen" allow="fullscreen"></iframe>
                                    <div class="absolute bottom-3 right-3 z-20">
                                        <a href="{{ $project->canva_url }}" target="_blank" rel="noopener noreferrer" class="bg-obsidian/90 hover:bg-neonRed text-white px-3 py-1.5 rounded-lg text-[10px] font-mono font-bold uppercase tracking-wider transition border border-borderSubtle flex items-center space-x-1.5 shadow-lg">
                                            <span>Open in Canva</span>
                                            <i class="fa-solid fa-external-link-alt text-[9px]"></i>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <img src="{{ $project->thumbnail }}" alt="{{ $project->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                            @endif
                            <div class="absolute top-4 left-4 bg-obsidian/90 backdrop-blur-md px-4 py-1.5 rounded-full text-xs font-mono font-bold text-neonRed border border-borderSubtle shadow-lg z-20">
                                {{ $project->category }}
                            </div>
                        </div>
                        <div class="p-8">
                            <h3 class="text-xl font-bold text-white group-hover:text-neonRed transition">{{ $project->title }}</h3>
                            <p class="text-gray-400 text-sm mt-3 leading-relaxed font-light">{{ $project->short_description }}</p>
                        </div>
                    </div>
                        <div class="px-8 pt-6 pb-2 flex items-center justify-between">
                            <span class="text-xs font-mono text-gray-500 flex items-center gap-2"><i class="fa-regular fa-eye"></i> {{ $project->views }} views</span>
                        </div>
                        <div class="px-8 pb-8 pt-0">
                            <a href="/project/{{ $project->slug }}" class="w-full bg-neonRed/10 hover:bg-neonRed text-neonRed hover:text-white py-2.5 rounded-xl text-xs font-mono font-bold uppercase tracking-wider transition flex items-center justify-center space-x-2">
                                <span>Case Study</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                </div>
                @empty
                @endforelse
                @endif

                {{-- Magazines (rendered as cards inside the same grid) --}}
                @if($category === 'All' || $category === 'Magazine')
                @forelse($magazines as $index => $magazine)
                <div class="glass-card border border-borderSubtle rounded-3xl overflow-hidden group hover:border-neonRed transition duration-500 flex flex-col justify-between shadow-2xl hover:-translate-y-2">
                    <div>
                        <div class="relative overflow-hidden aspect-video bg-obsidian cursor-pointer" onclick="window.location.href='{{ route('magazine.show', $magazine->id) }}'">
                            @if($magazine->cover_image_path)
                                <img src="{{ asset('storage/' . $magazine->cover_image_path) }}" alt="{{ $magazine->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-zinc-900 to-black p-5 flex flex-col justify-between border border-borderSubtle">
                                    <span class="text-[10px] font-mono text-neonRed uppercase tracking-widest">Digital Publication</span>
                                    <span class="text-[10px] font-mono text-neonRed font-bold group-hover:translate-x-1 transition">Open Viewer →</span>
                                </div>
                            @endif
                            <div class="absolute top-4 left-4 bg-obsidian/90 backdrop-blur-md px-4 py-1.5 rounded-full text-xs font-mono font-bold text-neonRed border border-borderSubtle shadow-lg">
                                Magazine
                            </div>
                        </div>
                        <div class="p-8">
                            <h3 class="text-xl font-bold text-white group-hover:text-neonRed transition">{{ $magazine->title }}</h3>
                            <p class="text-gray-400 text-sm mt-3 leading-relaxed font-light">{{ $magazine->description }}</p>
                        </div>
                    </div>
                    <div class="px-8 pb-8 pt-0 flex items-center justify-between border-t border-borderSubtle mt-4 pt-6">
                        <span class="text-xs font-mono text-gray-500 flex items-center gap-2"><i class="fa-regular fa-bookmark"></i> Publication #{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <a href="{{ route('magazine.show', $magazine->id) }}" class="bg-neonRed/10 hover:bg-neonRed text-neonRed hover:text-white px-5 py-2.5 rounded-xl text-xs font-mono font-bold uppercase tracking-wider transition flex items-center space-x-2">
                            <span>Read Full Book</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
                @empty
                @endforelse
                @endif

                @if((($category === 'Magazine') || ($category !== 'Magazine' && $projects->isEmpty())) && (empty($magazines) || $magazines->isEmpty()))
                <div class="col-span-3 text-center py-24 glass-card border border-borderSubtle rounded-3xl">
                    <p class="text-gray-400 text-base font-mono">No projects found in this sector.</p>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- EXPERIENCE & ABOUT -->
    <section id="experience" class="py-28 border-t border-borderSubtle scroll-section">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 lg:gap-12">
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
            <div class="text-center max-w-lg mx-auto mb-10">
                <span class="text-xs font-mono uppercase tracking-widest text-neonRed bg-neonRed/10 px-4 py-1.5 rounded-full border border-neonRed/20">Transmission</span>
                <h2 class="text-4xl font-black text-white mt-4">Initiate Partnership</h2>
                <p class="text-gray-400 text-sm mt-3 font-light">Diskusikan kebutuhan proyek digital skala enterprise Anda bersama saya.</p>
            </div>

            <!-- Direct Contact Email Card -->
            <div class="mb-10 bg-obsidian border border-neonRed/30 rounded-2xl p-5 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-lg shadow-neonGlow">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-2xl bg-neonRed/10 border border-neonRed/40 flex items-center justify-center text-neonRed text-xl">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-mono text-gray-400 uppercase tracking-widest">Direct Email Order / Message</p>
                        <a href="mailto:farrel88bala@gmail.com?subject=Halo%20Farrel%20-%20Pemesanan%20Proyek" class="text-white font-bold text-lg hover:text-neonRed transition">farrel88bala@gmail.com</a>
                    </div>
                </div>
                <a href="mailto:farrel88bala@gmail.com?subject=Halo%20Farrel%20-%20Pemesanan%20Proyek" class="bg-neonRed hover:bg-red-600 text-white px-6 py-3 rounded-xl text-xs font-mono font-bold uppercase tracking-wider transition flex items-center space-x-2 shadow-lg shadow-neonGlow">
                    <span>Email Now</span>
                    <i class="fa-solid fa-paper-plane text-[10px]"></i>
                </a>
            </div>

            <form onsubmit="event.preventDefault(); window.location.href='mailto:farrel88bala@gmail.com?subject=Halo%20Farrel%20-%20Pemesanan%20Proyek&body=' + encodeURIComponent('Nama: ' + this[0].value + '%0A%0AEmail: ' + this[1].value + '%0A%0APesan: ' + this[2].value);" class="space-y-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-mono text-gray-400 uppercase tracking-widest mb-2">Nama Lengkap</label>
                        <input type="text" required placeholder="Cth: Alexander..." class="w-full bg-obsidian border border-borderSubtle rounded-2xl px-5 py-4 text-sm text-white focus:outline-none focus:border-neonRed transition">
                    </div>
                    <div>
                        <label class="block text-xs font-mono text-gray-400 uppercase tracking-widest mb-2">Email Anda</label>
                        <input type="email" required placeholder="name@company.com..." class="w-full bg-obsidian border border-borderSubtle rounded-2xl px-5 py-4 text-sm text-white focus:outline-none focus:border-neonRed transition">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-mono text-gray-400 uppercase tracking-widest mb-2">Pesan & Kebutuhan Proyek</label>
                    <textarea rows="4" required placeholder="Tuliskan detail ruang lingkup proyek..." class="w-full bg-obsidian border border-borderSubtle rounded-2xl px-5 py-4 text-sm text-white focus:outline-none focus:border-neonRed transition"></textarea>
                </div>
                <div class="text-center pt-2">
                    <button type="submit" class="bg-neonRed hover:bg-red-600 text-white px-10 py-5 rounded-2xl font-mono text-xs uppercase tracking-widest font-bold shadow-2xl shadow-neonGlow transition w-full sm:w-auto flex items-center justify-center space-x-2 mx-auto">
                        <i class="fa-solid fa-paper-plane text-[10px]"></i>
                        <span>Kirim via Gmail</span>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- PREMIUM FOOTER -->
    <footer class="relative mt-12 border-t border-borderSubtle/40 bg-gradient-to-b from-transparent via-[#08060d]/80 to-[#04030a] backdrop-blur-2xl overflow-hidden">
        <!-- Decorative Ambient Glows -->
        <div class="absolute -top-32 left-1/4 w-[40vw] h-[40vw] rounded-full bg-neonRed/15 blur-[140px] pointer-events-none"></div>
        <div class="absolute -bottom-32 right-1/4 w-[40vw] h-[40vw] rounded-full bg-cyan-500/15 blur-[140px] pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-6 sm:px-10 pt-20 pb-10 z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 text-left">
                <!-- Column 1: Brand -->
                <div class="md:col-span-2 space-y-5">
                    <a href="#home" class="flex items-center space-x-3 group">
                        <div class="w-12 h-12 rounded-2xl glass-card flex items-center justify-center border border-neonRed/60 group-hover:border-neonRed transition shadow-lg shadow-neonGlow">
                            <i class="fa-solid fa-cube text-neonRed text-xl animate-pulse"></i>
                        </div>
                        <span class="text-2xl font-black tracking-wider text-white">FARREL<span class="text-neonRed">.</span></span>
                    </a>
                    <p class="text-sm text-gray-400 font-sans leading-relaxed max-w-md">
                        Crafting immersive digital experiences through the fusion of 3D artistry, UI/UX design, and creative engineering. A digital laboratory where architecture meets imagination.
                    </p>
                    <div class="flex items-center space-x-3 pt-2">
                        <a href="https://github.com/farrelzzzzzzz" target="_blank" class="w-10 h-10 rounded-xl glass-card border border-borderSubtle flex items-center justify-center text-gray-400 hover:text-white hover:border-neonRed transition-all hover:-translate-y-1">
                            <i class="fa-brands fa-github"></i>
                        </a>
                        <a href="https://www.linkedin.com/" target="_blank" class="w-10 h-10 rounded-xl glass-card border border-borderSubtle flex items-center justify-center text-gray-400 hover:text-cyan-400 hover:border-cyan-400 transition-all hover:-translate-y-1">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                        <a href="https://www.instagram.com/" target="_blank" class="w-10 h-10 rounded-xl glass-card border border-borderSubtle flex items-center justify-center text-gray-400 hover:text-purple-400 hover:border-purple-500 transition-all hover:-translate-y-1">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                        <a href="mailto:farrel88bala@gmail.com" class="w-10 h-10 rounded-xl glass-card border border-borderSubtle flex items-center justify-center text-gray-400 hover:text-yellow-400 hover:border-yellow-500 transition-all hover:-translate-y-1">
                            <i class="fa-solid fa-envelope"></i>
                        </a>
                    </div>
                </div>

                <!-- Column 2: Navigation -->
                <div class="space-y-5">
                    <h4 class="text-xs font-mono text-neonRed font-bold uppercase tracking-[0.2em]">Navigation</h4>
                    <ul class="space-y-3 text-sm font-sans text-gray-400">
                        <li><a href="#home" class="hover:text-white transition">Home</a></li>
                        <li><a href="#about" class="hover:text-white transition">About</a></li>
                        <li><a href="#works" class="hover:text-white transition">Works</a></li>
                        <li><a href="#experience" class="hover:text-white transition">Experience</a></li>
                        <li><a href="#connect" class="hover:text-white transition">Contact</a></li>
                    </ul>
                </div>

                <!-- Column 3: Capabilities -->
                <div class="space-y-5">
                    <h4 class="text-xs font-mono text-cyan-400 font-bold uppercase tracking-[0.2em]">Capabilities</h4>
                    <ul class="space-y-3 text-sm font-sans text-gray-400">
                        <li>3D Visualization & WebGL</li>
                        <li>UI/UX Architecture</li>
                        <li>Creative Direction</li>
                        <li>Frontend Engineering</li>
                        <li>Magazine & Editorial</li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Technical Bar -->
            <div class="mt-16 pt-8 border-t border-borderSubtle/50 flex flex-col md:flex-row items-center justify-between gap-4 text-[10px] font-mono uppercase tracking-widest text-gray-500">
                <p>© 2026 <span class="text-white font-bold">FARREL BALAPRADHANA</span> &middot; EXECUTIVE PORTFOLIO</p>
                <div class="flex items-center space-x-4">
                    <span class="flex items-center space-x-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-gray-400">All Systems Operational</span>
                    </span>
                    <span>v 1.0.6</span>
                </div>
            </div>
        </div>
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
            if (!container || container.clientWidth === 0) return;
            heroScene = new THREE.Scene();
            heroCamera = new THREE.PerspectiveCamera(50, container.clientWidth / container.clientHeight, 0.1, 1000);
            heroCamera.position.set(0, 0, 5);
            heroRenderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
            heroRenderer.setSize(container.clientWidth, container.clientHeight);
            heroRenderer.setPixelRatio(window.devicePixelRatio);
            container.appendChild(heroRenderer.domElement);

            heroScene.add(new THREE.AmbientLight(0xffffff, 2.5));
            const pLight = new THREE.PointLight(0xff1736, 12, 50);
            pLight.position.set(4, 4, 4);
            heroScene.add(pLight);

            const pLight2 = new THREE.PointLight(0x3b82f6, 10, 50);
            pLight2.position.set(-4, -4, 4);
            heroScene.add(pLight2);

            // Majestic Dragon Head Sculpture (Detailed 3D WebGL Dragon Head)
            const dragonGroup = new THREE.Group();

            const dragonMat = new THREE.MeshPhysicalMaterial({ 
                color: 0x1a1a24, 
                roughness: 0.2, 
                metalness: 0.9, 
                clearcoat: 1.0,
                clearcoatRoughness: 0.1,
                emissive: 0xff1736,
                emissiveIntensity: 0.15
            });

            const goldTrimMat = new THREE.MeshStandardMaterial({ 
                color: 0xffd700, 
                roughness: 0.2, 
                metalness: 0.95, 
                emissive: 0xff3366, 
                emissiveIntensity: 0.5 
            });

            // Snout / Muzzle
            const snoutGeo = new THREE.BoxGeometry(0.7, 0.6, 1.2);
            const snout = new THREE.Mesh(snoutGeo, dragonMat);
            snout.position.set(0, -0.1, 0.6);
            dragonGroup.add(snout);

            // Main Cranium / Head
            const headGeo = new THREE.DodecahedronGeometry(0.8, 0);
            headGeo.scale(1, 1.1, 1.4);
            const headMesh = new THREE.Mesh(headGeo, dragonMat);
            headMesh.position.set(0, 0.2, 0);
            dragonGroup.add(headMesh);

            // Horns (Left & Right)
            const hornGeo = new THREE.ConeGeometry(0.2, 1.4, 8);
            hornGeo.rotateX(Math.PI / 4);
            
            const leftHorn = new THREE.Mesh(hornGeo, goldTrimMat);
            leftHorn.position.set(0.5, 0.9, -0.3);
            leftHorn.rotation.z = -0.3;
            dragonGroup.add(leftHorn);

            const rightHorn = new THREE.Mesh(hornGeo, goldTrimMat);
            rightHorn.position.set(-0.5, 0.9, -0.3);
            rightHorn.rotation.z = 0.3;
            dragonGroup.add(rightHorn);

            // Glowing Eyes
            const eyeGeo = new THREE.SphereGeometry(0.12, 16, 16);
            const eyeMat = new THREE.MeshBasicMaterial({ color: 0xff1736 });
            
            const leftEye = new THREE.Mesh(eyeGeo, eyeMat);
            leftEye.position.set(0.35, 0.3, 0.5);
            dragonGroup.add(leftEye);

            const rightEye = new THREE.Mesh(eyeGeo, eyeMat);
            rightEye.position.set(-0.35, 0.3, 0.5);
            dragonGroup.add(rightEye);

            // Glowing Dragon Neck / Base
            const neckGeo = new THREE.CylinderGeometry(0.5, 0.8, 0.9, 16);
            const neck = new THREE.Mesh(neckGeo, dragonMat);
            neck.position.set(0, -0.7, -0.1);
            dragonGroup.add(neck);

            // Mystical Floating Ring
            const ringGeo = new THREE.TorusGeometry(1.3, 0.04, 32, 100);
            const ringMat = new THREE.MeshStandardMaterial({ color: 0xff1736, emissive: 0xff1736, emissiveIntensity: 1.0 });
            const ring = new THREE.Mesh(ringGeo, ringMat);
            ring.rotation.x = Math.PI / 2;
            ring.position.set(0, -0.2, 0);
            dragonGroup.add(ring);

            heroScene.add(dragonGroup);
            heroMesh = dragonGroup;

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
            if (!heroDragging) { 
                heroMesh.rotation.y += 0.008; 
                heroMesh.rotation.x += 0.004;
                if (heroMesh.children[0]) {
                    heroMesh.children[0].rotation.y -= 0.012;
                    heroMesh.children[0].rotation.x += 0.006;
                }
            }
            heroRenderer.render(heroScene, heroCamera);
        }

        let carScene, carCamera, carRenderer, carGroup, carDragging = false, prevCarMouse = {x: 0, y: 0};
        let carWheels = [];
        let carAnimating = false;
        function initCar3D() {
            if (carRenderer) return; // already initialized
            const container = document.getElementById('car-3d-container');
            if (!container || container.clientWidth === 0) return;
            carScene = new THREE.Scene();
            carCamera = new THREE.PerspectiveCamera(50, container.clientWidth / container.clientHeight, 0.1, 1000);
            carCamera.position.set(4, 3, 5);
            carCamera.lookAt(0, 0, 0);
            carRenderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
            carRenderer.setSize(container.clientWidth, container.clientHeight);
            carRenderer.setPixelRatio(window.devicePixelRatio);
            container.appendChild(carRenderer.domElement);

            // Studio Lighting
            carScene.add(new THREE.AmbientLight(0x222233, 2.0));
            const keyLight = new THREE.DirectionalLight(0xff1736, 4.5);
            keyLight.position.set(5, 8, 4);
            carScene.add(keyLight);
            const fillLight = new THREE.DirectionalLight(0x00f3ff, 3.0);
            fillLight.position.set(-5, -3, -4);
            carScene.add(fillLight);

            carGroup = new THREE.Group();

            // 1. Sleek Futuristic Formula / Interceptor Chassis
            const bodyMat = new THREE.MeshStandardMaterial({ color: 0x12121c, metalness: 0.95, roughness: 0.1 });
            const mainHull = new THREE.Mesh(new THREE.ConeGeometry(1.2, 3.6, 4), bodyMat);
            mainHull.rotation.x = Math.PI / 2;
            mainHull.position.y = 0.3;
            carGroup.add(mainHull);

            // 2. Neon Red Central Cockpit Canopy
            const cockpitMat = new THREE.MeshStandardMaterial({ color: 0xff1736, metalness: 0.8, roughness: 0.2, emissive: 0xff1736, emissiveIntensity: 0.3 });
            const cockpit = new THREE.Mesh(new THREE.CapsuleGeometry(0.4, 1.2, 8, 16), cockpitMat);
            cockpit.rotation.x = Math.PI / 2;
            cockpit.position.set(0, 0.6, 0.2);
            carGroup.add(cockpit);

            // 3. Side Aero Wings & Electric Cyan Strips
            const wingMat = new THREE.MeshStandardMaterial({ color: 0x181824, metalness: 0.9, roughness: 0.2 });
            const leftWing = new THREE.Mesh(new THREE.BoxGeometry(1.2, 0.1, 0.8), wingMat);
            leftWing.position.set(1.1, 0.2, 0);
            carGroup.add(leftWing);

            const rightWing = new THREE.Mesh(new THREE.BoxGeometry(1.2, 0.1, 0.8), wingMat);
            rightWing.position.set(-1.1, 0.2, 0);
            carGroup.add(rightWing);

            // Cyan Energy Trims
            const cyanMat = new THREE.MeshBasicMaterial({ color: 0x00f3ff });
            const leftTrim = new THREE.Mesh(new THREE.BoxGeometry(0.1, 0.12, 0.8), cyanMat);
            leftTrim.position.set(1.6, 0.2, 0);
            carGroup.add(leftTrim);

            const rightTrim = new THREE.Mesh(new THREE.BoxGeometry(0.1, 0.12, 0.8), cyanMat);
            rightTrim.position.set(-1.6, 0.2, 0);
            carGroup.add(rightTrim);

            // 4. Glowing Rear Reactor Wing
            const rearWing = new THREE.Mesh(new THREE.BoxGeometry(2.4, 0.15, 0.4), new THREE.MeshStandardMaterial({ color: 0x0a0a0f, metalness: 0.9, roughness: 0.3 }));
            rearWing.position.set(0, 0.7, -1.5);
            carGroup.add(rearWing);

            const reactorGlow = new THREE.Mesh(new THREE.BoxGeometry(2.0, 0.05, 0.05), new THREE.MeshBasicMaterial({ color: 0xff00ff }));
            reactorGlow.position.set(0, 0.8, -1.5);
            carGroup.add(reactorGlow);

            // 5. Sci-Fi Floating Wheels (4 glowing rims)
            carWheels = [];
            const wheelGeo = new THREE.TorusGeometry(0.35, 0.1, 16, 32);
            const wheelMat = new THREE.MeshStandardMaterial({ color: 0xff1736, metalness: 0.8, roughness: 0.2 });

            [[-1.1, 1.2], [1.1, 1.2], [-1.1, -1.0], [1.1, -1.0]].forEach(([x, z]) => {
                const wheel = new THREE.Mesh(wheelGeo, wheelMat);
                wheel.rotation.y = Math.PI / 2;
                wheel.position.set(x, 0.2, z);
                carGroup.add(wheel);
                carWheels.push(wheel);
            });

            carScene.add(carGroup);

            container.addEventListener('mousedown', (e) => { carDragging = true; prevCarMouse = { x: e.clientX, y: e.clientY }; });
            window.addEventListener('mousemove', (e) => {
                if (!carDragging) return;
                carGroup.rotation.y += (e.clientX - prevCarMouse.x) * 0.01;
                carGroup.rotation.x += (e.clientY - prevCarMouse.y) * 0.01;
                prevCarMouse = { x: e.clientX, y: e.clientY };
            });
            window.addEventListener('mouseup', () => { carDragging = false; });
            carAnimating = true;
            animateCar();
        }
        function animateCar() {
            if (!carAnimating) return;
            requestAnimationFrame(animateCar);
            if (!carDragging) {
                carGroup.rotation.y += 0.007;
                carGroup.position.y = Math.sin(Date.now() * 0.003) * 0.1; // hovering effect
            }
            carWheels.forEach(w => w.rotation.z += 0.03);
            carRenderer.render(carScene, carCamera);
        }
        function resetCarCamera() { carGroup.rotation.set(0, 0, 0); carGroup.position.set(0, 0, 0); }

        let droneScene, droneCamera, droneRenderer, droneGroup, droneDragging = false, prevDroneMouse = {x: 0, y: 0};
        let rotor1, rotor2, droneCore;
        let droneAnimating = false;
        function initDrone3D() {
            if (droneRenderer) return;
            const container = document.getElementById('drone-3d-container');
            if (!container || container.clientWidth === 0) return;
            droneAnimating = true;
            droneScene = new THREE.Scene();
            droneCamera = new THREE.PerspectiveCamera(55, container.clientWidth / container.clientHeight, 0.1, 1000);
            droneCamera.position.set(0, 3, 6);
            droneCamera.lookAt(0, 0, 0);
            droneRenderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
            droneRenderer.setSize(container.clientWidth, container.clientHeight);
            droneRenderer.setPixelRatio(window.devicePixelRatio);
            container.appendChild(droneRenderer.domElement);

            droneScene.add(new THREE.AmbientLight(0x222233, 2.0));
            const keyLight = new THREE.DirectionalLight(0xff1736, 4.0);
            keyLight.position.set(6, 8, 5);
            droneScene.add(keyLight);
            const fillLight = new THREE.DirectionalLight(0x00f3ff, 3.5);
            fillLight.position.set(-6, -2, -4);
            droneScene.add(fillLight);

            droneGroup = new THREE.Group();
            const core = new THREE.Mesh(new THREE.IcosahedronGeometry(0.8, 0), new THREE.MeshStandardMaterial({ color: 0x111118, metalness: 0.95, roughness: 0.15 }));
            droneCore = core;
            droneGroup.add(core);

            const innerSphere = new THREE.Mesh(new THREE.SphereGeometry(0.45, 16, 16), new THREE.MeshBasicMaterial({ color: 0x00f3ff }));
            core.add(innerSphere);

            const armorMat = new THREE.MeshStandardMaterial({ color: 0x1a1a26, metalness: 0.9, roughness: 0.3 });
            for (let i = 0; i < 4; i++) {
                const angle = (i * Math.PI) / 2;
                const plate = new THREE.Mesh(new THREE.BoxGeometry(0.3, 1.4, 0.15), armorMat);
                plate.position.set(Math.cos(angle) * 1.3, 0.2, Math.sin(angle) * 1.3);
                plate.rotation.y = -angle;
                plate.rotation.z = 0.35;
                droneGroup.add(plate);

                const edge = new THREE.Mesh(new THREE.BoxGeometry(0.08, 1.3, 0.05), new THREE.MeshBasicMaterial({ color: i % 2 === 0 ? 0xff1736 : 0x00f3ff }));
                edge.position.set(Math.cos(angle) * 1.45, 0.2, Math.sin(angle) * 1.45);
                edge.rotation.y = -angle;
                edge.rotation.z = 0.35;
                droneGroup.add(edge);
            }

            rotor1 = new THREE.Mesh(new THREE.TorusGeometry(1.8, 0.04, 16, 64), new THREE.MeshStandardMaterial({ color: 0xa855f7, metalness: 0.8, roughness: 0.2 }));
            rotor1.rotation.x = Math.PI / 2;
            droneGroup.add(rotor1);

            rotor2 = new THREE.Mesh(new THREE.TorusGeometry(2.2, 0.03, 16, 64), new THREE.MeshStandardMaterial({ color: 0x00f3ff, metalness: 0.8, roughness: 0.2 }));
            rotor2.rotation.y = Math.PI / 2;
            droneGroup.add(rotor2);

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
            if (!droneAnimating) return;

            requestAnimationFrame(animateDrone);

            if (!droneDragging) {
                droneGroup.rotation.y += 0.008;
                droneGroup.rotation.z = Math.sin(Date.now() * 0.002) * 0.15;
            }
            if (rotor1) rotor1.rotation.z += 0.02;
            if (rotor2) rotor2.rotation.x -= 0.025;
            if (droneCore) droneCore.rotation.y -= 0.01;
            droneRenderer.render(droneScene, droneCamera);
        }

        // BACKGROUND OPTIMIZED ANIMATION - Mobile-aware
        document.addEventListener("DOMContentLoaded", () => {
            const canvas = document.getElementById('bg-particle-canvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            let width = canvas.width = window.innerWidth;
            let height = canvas.height = window.innerHeight;

            // Detect mobile / low-power device - reduce intensity
            const isMobile = window.innerWidth < 768;
            const isLowPower = navigator.hardwareConcurrency && navigator.hardwareConcurrency < 4;

            window.addEventListener('resize', () => {
                width = canvas.width = window.innerWidth;
                height = canvas.height = window.innerHeight;
            });

            let mouseX = width / 2;
            let mouseY = height / 2;
            let lastMouseX = mouseX, lastMouseY = mouseY;
            let mouseActive = false;
            let scrollY = 0;

            window.addEventListener('mousemove', (e) => {
                lastMouseX = mouseX;
                lastMouseY = mouseY;
                mouseX = e.clientX;
                mouseY = e.clientY;
                mouseActive = true;
            });

            window.addEventListener('scroll', () => {
                scrollY = window.scrollY;
            }, { passive: true });

            // Hide background canvas if user prefers reduced motion or low-power
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                canvas.style.display = 'none';
                return;
            }

            // Layer 1: Dense moving colored dots with bloom light
            const particles = [];
            const count = isMobile ? (isLowPower ? 180 : 250) : (isLowPower ? 400 : 700);
            const colors = ['#ff0033', '#00f3ff', '#a855f7', '#00ff66', '#ff00ff', '#ffcc00', '#3b82f6', '#34d399', '#f43f5e', '#38bdf8'];

            for (let i = 0; i < count; i++) {
                particles.push({
                    x: Math.random() * width,
                    y: Math.random() * height,
                    vx: (Math.random() - 0.5) * 1.2, // Smooth sliding motion X
                    vy: (Math.random() - 0.5) * 1.2 - 0.4, // Smooth sliding motion Y (drifting upwards)
                    radius: Math.random() * 1.6 + 0.7, // Crisp small dots
                    colorIndex: Math.floor(Math.random() * colors.length),
                    nextColorIndex: Math.floor(Math.random() * colors.length),
                    colorProgress: Math.random(),
                    colorChangeSpeed: Math.random() * 0.01 + 0.003,
                    alpha: 0.9,
                    bloomSize: Math.random() * 12 + 6 // Bloom light effect
                });
            }

            // Layer 2: Geometric shapes - fewer on mobile
            const shapes = [];
            const shapeCount = isMobile ? 4 : 8;

            for (let i = 0; i < shapeCount; i++) {
                shapes.push({
                    x: Math.random() * width,
                    y: Math.random() * height,
                    size: Math.random() * 25 + 18,
                    rotation: Math.random() * Math.PI * 2,
                    rotationSpeed: (Math.random() - 0.5) * 0.004,
                    driftX: (Math.random() - 0.5) * 0.25,
                    driftY: (Math.random() - 0.5) * 0.25,
                    type: ['triangle', 'square', 'hexagon', 'circle'][Math.floor(Math.random() * 4)],
                    color: colors[Math.floor(Math.random() * colors.length)],
                    alpha: 0.08
                });
            }

            function drawShape(shape) {
                ctx.save();
                ctx.translate(shape.x, shape.y);
                ctx.rotate(shape.rotation);
                ctx.strokeStyle = shape.color;
                ctx.globalAlpha = shape.alpha;
                ctx.lineWidth = 1.2;
                ctx.shadowBlur = 12;
                ctx.shadowColor = shape.color;

                if (shape.type === 'triangle') {
                    ctx.beginPath();
                    ctx.moveTo(0, -shape.size);
                    ctx.lineTo(shape.size * 0.866, shape.size * 0.5);
                    ctx.lineTo(-shape.size * 0.866, shape.size * 0.5);
                    ctx.closePath();
                    ctx.stroke();
                } else if (shape.type === 'square') {
                    ctx.strokeRect(-shape.size / 2, -shape.size / 2, shape.size, shape.size);
                } else if (shape.type === 'hexagon') {
                    ctx.beginPath();
                    for (let i = 0; i < 6; i++) {
                        const angle = (Math.PI / 3) * i;
                        const x = shape.size * Math.cos(angle);
                        const y = shape.size * Math.sin(angle);
                        if (i === 0) ctx.moveTo(x, y);
                        else ctx.lineTo(x, y);
                    }
                    ctx.closePath();
                    ctx.stroke();
                } else if (shape.type === 'circle') {
                    ctx.beginPath();
                    ctx.arc(0, 0, shape.size, 0, Math.PI * 2);
                    ctx.stroke();
                }
                ctx.restore();
            }

            // FPS throttling - skip frames on slow devices
            let lastFrame = 0;
            const targetFPS = isLowPower ? 30 : 60;
            const frameInterval = 1000 / targetFPS;

            function animateBackground(timestamp) {
                if (timestamp - lastFrame < frameInterval) {
                    requestAnimationFrame(animateBackground);
                    return;
                }
                lastFrame = timestamp;

                ctx.clearRect(0, 0, width, height);

                // Shapes
                shapes.forEach(shape => {
                    shape.x += shape.driftX;
                    shape.y += shape.driftY - scrollY * 0.0008;
                    shape.rotation += shape.rotationSpeed;
                    if (shape.x < -50) shape.x = width + 50;
                    if (shape.x > width + 50) shape.x = -50;
                    if (shape.y < -50) shape.y = height + 50;
                    if (shape.y > height + 50) shape.y = -50;
                    drawShape(shape);
                });

                // Particles - smooth sliding motion, color morphing & strong bloom light
                particles.forEach((p, index) => {
                    p.x += p.vx;
                    p.y += p.vy - scrollY * 0.0003;

                    // Smooth color morphing transition
                    p.colorProgress += p.colorChangeSpeed;
                    if (p.colorProgress >= 1) {
                        p.colorProgress = 0;
                        p.colorIndex = p.nextColorIndex;
                        p.nextColorIndex = Math.floor(Math.random() * colors.length);
                    }

                    const hexToRgb = (hex) => {
                        let bigint = parseInt(hex.replace('#',''), 16);
                        return [(bigint >> 16) & 255, (bigint >> 8) & 255, bigint & 255];
                    };
                    const c1 = hexToRgb(colors[p.colorIndex]);
                    const c2 = hexToRgb(colors[p.nextColorIndex]);
                    const r = Math.round(c1[0] + (c2[0] - c1[0]) * p.colorProgress);
                    const g = Math.round(c1[1] + (c2[1] - c1[1]) * p.colorProgress);
                    const b = Math.round(c1[2] + (c2[2] - c1[2]) * p.colorProgress);
                    const currentColor = `rgb(${r}, ${g}, ${b})`;

                    if (p.x < 0) p.x = width;
                    if (p.x > width) p.x = 0;
                    if (p.y < 0) p.y = height;
                    if (p.y > height) p.y = 0;

                    // Draw star particle with Bloom Light effect
                    ctx.save();
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                    ctx.fillStyle = currentColor;
                    ctx.globalAlpha = p.alpha;
                    ctx.shadowBlur = p.bloomSize;
                    ctx.shadowColor = currentColor;
                    ctx.fill();
                    ctx.restore();

                    // Skip expensive line connections on mobile
                    if (isMobile) return;

                    // Connect nearby particles for stellar constellation effect - desktop only
                    for (let j = index + 1; j < particles.length; j += 2) { // step by 2 for performance with 700 particles
                        const p2 = particles[j];
                        const dx = p.x - p2.x;
                        const dy = p.y - p2.y;
                        const dist = dx * dx + dy * dy;
                        if (dist < 10000) { // 100px radius
                            ctx.beginPath();
                            ctx.moveTo(p.x, p.y);
                            ctx.lineTo(p2.x, p2.y);
                            ctx.strokeStyle = currentColor;
                            ctx.globalAlpha = (1 - Math.sqrt(dist) / 100) * 0.08 * p.alpha;
                            ctx.lineWidth = 0.5;
                            ctx.shadowBlur = 0;
                            ctx.stroke();
                        }
                    }
                });

                requestAnimationFrame(animateBackground);
            }
            requestAnimationFrame(animateBackground);

            // CUSTOM MOUSE FOLLOWER LOGIC
            const cursor = document.getElementById('custom-cursor');
            const cursorDot = document.getElementById('custom-cursor-dot');
            let mouseXPos = 0, mouseYPos = 0;
            let cursorX = 0, cursorY = 0;

            window.addEventListener('mousemove', (e) => {
                mouseXPos = e.clientX;
                mouseYPos = e.clientY;
                if (cursorDot) cursorDot.style.transform = `translate(${mouseXPos}px, ${mouseYPos}px) translate(-50%, -50%)`;
            });

            function renderCursor() {
                cursorX += (mouseXPos - cursorX) * 0.15;
                cursorY += (mouseYPos - cursorY) * 0.15;
                if (cursor) {
                    cursor.style.transform = `translate(${cursorX}px, ${cursorY}px) translate(-50%, -50%)`;
                }
                requestAnimationFrame(renderCursor);
            }
            renderCursor();

            // Hover effects on interactive items - star scales and rotates
            document.querySelectorAll('a, button, input, textarea, .interactive-item').forEach(el => {
                el.addEventListener('mouseenter', () => {
                    if (cursor) cursor.style.transform = `translate(${cursorX}px, ${cursorY}px) translate(-50%, -50%) scale(1.8) rotate(180deg)`;
                });
                el.addEventListener('mouseleave', () => {
                    if (cursor) cursor.style.transform = `translate(${cursorX}px, ${cursorY}px) translate(-50%, -50%) scale(1) rotate(0deg)`;
                });
            });

            // Add slow continuous rotation to the star
            let starRotation = 0;
            function rotateStar() {
                starRotation += 0.5;
                const star = document.getElementById('cursor-star');
                if (star) star.style.transform = `rotate(${starRotation}deg)`;
                requestAnimationFrame(rotateStar);
            }
            rotateStar();
        });
        function resetDroneCamera() { droneGroup.rotation.set(0, 0, 0); }

        let torusScene, torusCamera, torusRenderer, torusMesh, torusDragging = false, prevTorusMouse = {x: 0, y: 0};
        let torusAnimating = false;
        function initTorus3D() {
            if (torusRenderer) return;
            const container = document.getElementById('torus-3d-container');
            if (!container || container.clientWidth === 0) return;
            torusAnimating = true;
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
            if (!torusAnimating) return;

            requestAnimationFrame(animateTorus);

            if (!torusDragging) {
                torusMesh.rotation.y += 0.005;
                torusMesh.rotation.z += 0.002;
            }
            torusRenderer.render(torusScene, torusCamera);
        }
        function resetTorusCamera() { torusMesh.rotation.set(0, 0, 0); }

        window.addEventListener('load', () => {
            initHero3D();
            // Robust init: keep retrying until all 3D viewers successfully mount
            function tryInitAll(retries = 30) {
                const okCar = !!document.getElementById('car-3d-container') && carRenderer;
                const okDrone = !!document.getElementById('drone-3d-container') && droneRenderer;
                const okTorus = !!document.getElementById('torus-3d-container') && torusRenderer;
                try { initCar3D(); } catch(e) { console.error('Car init error:', e); }
                try { initDrone3D(); } catch(e) { console.error('Drone init error:', e); }
                try { initTorus3D(); } catch(e) { console.error('Torus init error:', e); }
                if ((!carRenderer || !droneRenderer || !torusRenderer) && retries > 0) {
                    setTimeout(() => tryInitAll(retries - 1), 200);
                }
            }
            tryInitAll();
        });
    </script>

    <!-- DUAL EDITORIAL LIBRARY -->
    <script>
        const M1_TOTAL = 16;
        const M2_TOTAL = 16;
        let m1Sheet = 0;
        function updateMag1() {
            const indicator = document.getElementById('page-indicator-1');
            if (m1Sheet === 0) { indicator.innerText = "Cover"; }
            else if (m1Sheet === M1_TOTAL) { indicator.innerText = "Back Cover"; }
            else { indicator.innerText = "Hal. " + (m1Sheet * 2 - 1) + "-" + (m1Sheet * 2); }
            for (let i = 1; i <= M1_TOTAL; i++) {
                const s = document.getElementById('m1-sheet-' + i);
                if (!s) continue;
                if (m1Sheet >= i) {
                    s.classList.add('flipped');
                    s.style.zIndex = 10 + i;
                } else {
                    s.classList.remove('flipped');
                    s.style.zIndex = 30 - i;
                }
            }
        }
        function nextPage1() { if (m1Sheet < M1_TOTAL) { m1Sheet++; updateMag1(); } else { m1Sheet = 0; updateMag1(); } }
        function prevPage1() { if (m1Sheet > 0) { m1Sheet--; updateMag1(); } }

        let m2Sheet = 0;
        function updateMag2() {
            const indicator = document.getElementById('page-indicator-2');
            if (m2Sheet === 0) { indicator.innerText = "Cover"; }
            else if (m2Sheet === M2_TOTAL) { indicator.innerText = "Back Cover"; }
            else { indicator.innerText = "Hal. " + (m2Sheet * 2 - 1) + "-" + (m2Sheet * 2); }
            for (let i = 1; i <= M2_TOTAL; i++) {
                const s = document.getElementById('m2-sheet-' + i);
                if (!s) continue;
                if (m2Sheet >= i) {
                    s.classList.add('flipped');
                    s.style.zIndex = 10 + i;
                } else {
                    s.classList.remove('flipped');
                    s.style.zIndex = 30 - i;
                }
            }
        }
        function nextPage2() { if (m2Sheet < M2_TOTAL) { m2Sheet++; updateMag2(); } else { m2Sheet = 0; updateMag2(); } }
        function prevPage2() { if (m2Sheet > 0) { m2Sheet--; updateMag2(); } }
    </script>

</body>
</html>
