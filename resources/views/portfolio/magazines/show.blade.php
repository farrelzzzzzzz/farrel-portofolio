<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $magazine->title }} — Farrel Balapradhana</title>
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
<body class="bg-darkBg text-gray-100 font-sans antialiased selection:bg-accentRed selection:text-white">

    <header class="sticky top-0 z-50 bg-darkBg/85 backdrop-blur-md border-b border-cardBorder">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ route('portfolio.index') }}" class="text-xl font-bold text-white flex items-center space-x-2">
                <i class="fa-solid fa-arrow-left text-sm text-accentRed"></i>
                <span>Kembali ke Beranda</span>
            </a>
            <a href="{{ route('portfolio.index') }}" class="text-2xl font-black tracking-wider text-white">FARREL<span class="text-accentRed">.</span></a>
        </div>
    </header>

    <main class="py-12 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-8">
            
            <!-- Header Info -->
            <div class="space-y-3">
                <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold tracking-wider uppercase bg-red-500/10 text-red-500 border border-red-500/20">
                    MAGAZINE
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white">
                    {{ $magazine->title }}
                </h1>
            </div>

            <!-- Cover / Thumbnail Magazine -->
            <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-2xl p-6 sm:p-8 flex justify-center items-center">
                @if(!empty($magazine->cover_image_path))
                    <img src="{{ asset('storage/' . $magazine->cover_image_path) }}" alt="{{ $magazine->title }}" class="max-h-[500px] w-auto object-contain rounded-lg shadow-lg border border-slate-800">
                @else
                    <div class="w-full h-80 sm:h-96 bg-slate-950 border border-dashed border-slate-800 rounded-xl flex flex-col items-center justify-center text-slate-500 space-y-3">
                        <svg class="w-16 h-16 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span class="text-sm font-medium tracking-wide text-slate-400">No Cover Available</span>
                    </div>
                @endif
            </div>

            <!-- Interactive Magazine Viewer Section -->
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 sm:p-8 space-y-6">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <span>📖</span> Interactive Magazine Viewer (Flipbook)
                </h2>

                <div id="flipbook-container" class="w-full bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950 border border-slate-800 rounded-xl flex flex-col items-center justify-center p-4 sm:p-6 relative min-h-[500px] shadow-inner">

                    <style>
                        /* Pastikan setiap halaman PDF dirender sebagai portrait
                           dan tidak melebar memenuhi viewport. Aspect ratio
                           sudah dijaga via cappedWidth/cappedHeight di JS. */
                        #flipbook .page,
                        #flipbook .page canvas {
                            display: block;
                        }
                        /* PageFlip memposisikan children absolut, jadi parent
                           butuh dimensi tetap dan overflow yang terkontrol. */
                        #flipbook {
                            position: relative;
                            overflow: visible;
                        }
                    </style>

                    <!-- Loading State -->
                    <div id="pdf-loading" class="text-slate-400 text-sm py-12 flex flex-col items-center gap-3">
                        <svg class="animate-spin h-8 w-8 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Loading Magazine...</span>
                    </div>

                    <!-- Error State -->
                    <div id="pdf-error" class="hidden text-red-400 text-sm py-12 text-center">
                        Unable to load this magazine.
                    </div>

                    <!-- Flipbook Wrapper -->
                    <div id="flipbook-wrapper" class="hidden w-full max-w-[1000px] mx-auto flex flex-col items-center justify-center overflow-hidden py-4 gap-4">
                        <div id="flipbook" class="shadow-[0_30px_60px_-15px_rgba(0,0,0,0.7)] ring-1 ring-black/30 rounded-sm transition-transform duration-300 ease-out origin-center"></div>
                    </div>

                    <!-- Zoom & Page Controls -->
                    <div id="flipbook-controls" class="hidden flex flex-col items-center justify-center gap-3 mt-2 pt-4 border-t border-slate-800/80 w-full">
                        <!-- Row 1: navigation (Previous / page-info / Next) -->
                        <div class="flex items-center justify-center gap-3 w-full">
                            <button id="prev-page" aria-label="Previous page" class="group inline-flex items-center gap-2 px-4 py-2 bg-slate-900 hover:bg-red-600 border border-slate-700 hover:border-red-500 text-slate-200 hover:text-white text-sm font-medium rounded-full transition-all shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                                <span>Previous</span>
                            </button>

                            <span id="page-info" class="text-sm font-medium text-slate-300 inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-800/70 border border-slate-700 rounded-full">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Page <span id="current-page-num" class="text-white font-semibold mx-1">1</span> / <span id="total-page-num" class="text-white font-semibold ml-1">1</span>
                            </span>

                            <button id="next-page" aria-label="Next page" class="group inline-flex items-center gap-2 px-4 py-2 bg-slate-900 hover:bg-red-600 border border-slate-700 hover:border-red-500 text-slate-200 hover:text-white text-sm font-medium rounded-full transition-all shadow-sm hover:shadow-md">
                                <span>Next</span>
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>

                        <!-- Row 2: zoom & fullscreen controls -->
                        <div class="flex items-center justify-center gap-2 flex-wrap">
                            <button id="zoom-out" aria-label="Zoom out" title="Zoom out" class="group inline-flex items-center justify-center w-9 h-9 bg-slate-900 hover:bg-red-600 border border-slate-700 hover:border-red-500 text-slate-200 hover:text-white rounded-full transition-all shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M10 7v6m-3-3h6m5 6a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </button>

                            <button id="zoom-reset" aria-label="Reset zoom" title="Reset zoom" class="inline-flex items-center justify-center min-w-[60px] h-9 px-3 bg-slate-900 hover:bg-slate-800 border border-slate-700 text-slate-200 text-xs font-semibold rounded-full transition-all shadow-sm">
                                <span id="zoom-level">100%</span>
                            </button>

                            <button id="zoom-in" aria-label="Zoom in" title="Zoom in" class="group inline-flex items-center justify-center w-9 h-9 bg-slate-900 hover:bg-red-600 border border-slate-700 hover:border-red-500 text-slate-200 hover:text-white rounded-full transition-all shadow-sm hover:shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M11 7v6m3-3H8m10 6a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </button>

                            <span class="mx-1 h-5 w-px bg-slate-700" aria-hidden="true"></span>

                            <button id="zoom-fit" aria-label="Fit to width" title="Fit to width" class="inline-flex items-center gap-1.5 px-3 h-9 bg-slate-900 hover:bg-slate-800 border border-slate-700 text-slate-200 text-xs font-medium rounded-full transition-all shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5v4m0-4h-4"/></svg>
                                <span>Fit</span>
                            </button>

                            <span class="mx-1 h-5 w-px bg-slate-700" aria-hidden="true"></span>

                            <button id="fullscreen-btn" aria-label="Toggle Fullscreen" title="Toggle Fullscreen" class="inline-flex items-center gap-1.5 px-3.5 h-9 bg-slate-900 hover:bg-red-600 border border-slate-700 hover:border-red-500 text-slate-200 hover:text-white text-xs font-medium rounded-full transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l-5 5m11-1V4m0 0h-4m4 0l5 5M4 16v4m0 0h4m-4 0l-5 5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                                <span>Fullscreen</span>
                            </button>

                            <span class="mx-1 h-5 w-px bg-slate-700" aria-hidden="true"></span>

                            <a id="download-btn" href="{{ route('magazine.pdf', $magazine) }}" download="{{ \Illuminate\Support\Str::slug($magazine->title) }}.pdf" aria-label="Download Magazine PDF" title="Download Magazine PDF" class="inline-flex items-center gap-1.5 px-3.5 h-9 bg-red-600 hover:bg-red-700 border border-red-600 text-white text-xs font-medium rounded-full transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/></svg>
                                <span>Download</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            @if(!empty($magazine->pdf_path))
                <!-- Include PDF.js and StPageFlip CDN -->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/page-flip@2.0.7/dist/js/page-flip.browser.js"></script>
                <script>
                    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

                    // Use the streaming endpoint so Laravel's BinaryFileResponse
                    // handles the request. We then convert it to a Blob URL so
                    // pdf.js never issues a range/XHR request that the dev
                    // server might mis-handle as 204.
                    const url = "{{ route('magazine.pdf', $magazine) }}";
                    console.log('[FLIPBOOK] PDF URL:', url);
                    console.log('[FLIPBOOK] pdfjs version:', pdfjsLib.version);
                    console.log('[FLIPBOOK] workerSrc:', pdfjsLib.GlobalWorkerOptions.workerSrc);

                    const loadingElement = document.getElementById('pdf-loading');
                    const errorElement = document.getElementById('pdf-error');
                    const wrapperElement = document.getElementById('flipbook-wrapper');
                    const controlsElement = document.getElementById('flipbook-controls');
                    const flipbookElement = document.getElementById('flipbook');

                    const prevBtn = document.getElementById('prev-page');
                    const nextBtn = document.getElementById('next-page');
                    const currentPageSpan = document.getElementById('current-page-num');
                    const totalPageSpan = document.getElementById('total-page-num');

                    let pageFlip = null;
                    let blobUrl = null;

                    (async function() {
                        try {
                            // ---- LANGKAH 4: native browser fetch (bukan curl) ----
                            console.log('[FLIPBOOK] FETCH URL:', url);
                            console.log('[FLIPBOOK] FETCH OPTIONS:', { method: 'GET', cache: 'no-store' });

                            const response = await fetch(url, { method: 'GET', cache: 'no-store' });

                            console.log('[FLIPBOOK] FETCH RESPONSE:', {
                                status: response.status,
                                statusText: response.statusText,
                                url: response.url,
                                redirected: response.redirected,
                                contentType: response.headers.get('content-type'),
                                contentLength: response.headers.get('content-length')
                            });

                            const blob = await response.blob();
                            console.log('[FLIPBOOK] Native fetch:', {
                                status: response.status,
                                contentType: response.headers.get('content-type'),
                                contentLength: response.headers.get('content-length'),
                                blobSize: blob.size
                            });

                            if (!response.ok || blob.size === 0) {
                                throw new Error(
                                    'Browser cannot receive PDF: HTTP ' + response.status + ', ' + blob.size + ' bytes'
                                );
                            }

                            // ---- LANGKAH 5 / 6: feed pdf.js a Blob URL ----
                            blobUrl = URL.createObjectURL(blob);
                            console.log('[FLIPBOOK] getDocument started (blob URL)');
                            const loadingTask = pdfjsLib.getDocument({
                                url: blobUrl,
                                withCredentials: false,
                                disableRange: true,
                                disableStream: true,
                                disableAutoFetch: true
                            });

                            const pdfDoc = await loadingTask.promise;
                            console.log('[FLIPBOOK] PDF LOADED:', pdfDoc.numPages, 'pages');

                            const numPages = pdfDoc.numPages;
                            totalPageSpan.textContent = Math.min(numPages, 10);

                            // Ukuran A4 Portrait pas agar cover awal tampil sempurna di sisi kanan (single cover mode)
                            const TARGET_SINGLE_WIDTH = 450;
                            const TARGET_SINGLE_HEIGHT = 636;
                            for (let i = 1; i <= Math.min(numPages, 10); i++) {
                                const page = await pdfDoc.getPage(i);
                                const baseViewport = page.getViewport({ scale: 1.0 });
                                const renderScale = TARGET_SINGLE_WIDTH / baseViewport.width;
                                const pageViewport = page.getViewport({ scale: renderScale });

                                const canvas = document.createElement('canvas');
                                const context = canvas.getContext('2d');
                                canvas.height = pageViewport.height;
                                canvas.width = pageViewport.width;

                                await page.render({
                                    canvasContext: context,
                                    viewport: pageViewport
                                }).promise;

                                const pageDiv = document.createElement('div');
                                pageDiv.className = 'page bg-white shadow-md overflow-hidden flex items-center justify-center';
                                pageDiv.style.width = pageViewport.width + 'px';
                                pageDiv.style.height = pageViewport.height + 'px';
                                pageDiv.style.borderRadius = '2px';
                                pageDiv.appendChild(canvas);

                                flipbookElement.appendChild(pageDiv);
                            }

                            loadingElement.style.display = 'none';
                            wrapperElement.classList.remove('hidden');
                            controlsElement.classList.remove('hidden');

                            const firstCanvas = flipbookElement.querySelector('.page canvas');
                            const singleWidth = firstCanvas ? firstCanvas.width : 360;
                            const singleHeight = firstCanvas ? firstCanvas.height : 510;

                            const flipWidth = singleWidth * 2;
                            const flipHeight = singleHeight;

                            flipbookElement.style.width = flipWidth + 'px';
                            flipbookElement.style.height = flipHeight + 'px';

                            const MAX_SINGLE_WIDTH = 450;   // -> max spread 900
                            const MAX_SINGLE_HEIGHT = 636;  // A4 Portrait ratio exact (450 * 1.414)
                            let cappedWidth = Math.min(singleWidth, MAX_SINGLE_WIDTH);
                            let cappedHeight = Math.min(singleHeight, MAX_SINGLE_HEIGHT);
                            if (singleHeight > MAX_SINGLE_HEIGHT) {
                                cappedWidth = singleWidth * (MAX_SINGLE_HEIGHT / singleHeight);
                                cappedHeight = MAX_SINGLE_HEIGHT;
                            }
                            const cappedFlipWidth = cappedWidth * 2;
                            const cappedFlipHeight = cappedHeight;

                            pageFlip = new St.PageFlip(flipbookElement, {
                                width: Math.round(cappedFlipWidth),
                                height: Math.round(cappedFlipHeight),
                                size: 'fixed',
                                minWidth: 280,
                                maxWidth: 2000,
                                minHeight: 360,
                                maxHeight: 1600,
                                maxShadowOpacity: 0.35,
                                showCover: true,
                                mobileScrollSupport: true,
                                usePortrait: false,
                                startZIndex: 0,
                                autoSize: false,
                                flippingTime: 700
                            });

                            pageFlip.loadFromHTML(flipbookElement.querySelectorAll('.page'));

                            pageFlip.on('flip', (e) => {
                                currentPageSpan.textContent = e.data + 1;
                            });

                            // ============================================
                            // ZOOM CONTROLS
                            // ============================================
                            const ZOOM_MIN = 0.5;
                            const ZOOM_MAX = 2.5;
                            const ZOOM_STEP = 0.15;
                            let zoomLevel = 1.0;

                            const zoomInBtn = document.getElementById('zoom-in');
                            const zoomOutBtn = document.getElementById('zoom-out');
                            const zoomResetBtn = document.getElementById('zoom-reset');
                            const zoomFitBtn = document.getElementById('zoom-fit');
                            const fullscreenBtn = document.getElementById('fullscreen-btn');
                            const zoomLevelLabel = document.getElementById('zoom-level');
                            const flipbookContainer = document.getElementById('flipbook-container');

                            function applyZoom(value) {
                                zoomLevel = Math.max(ZOOM_MIN, Math.min(ZOOM_MAX, value));
                                flipbookElement.style.transform = `scale(${zoomLevel})`;
                                flipbookElement.style.transformOrigin = 'center center';
                                flipbookElement.style.marginTop = '0px';
                                flipbookElement.style.marginBottom = '0px';
                                flipbookElement.style.marginLeft = '0px';
                                flipbookElement.style.marginRight = '0px';
                                if (wrapperElement) {
                                    wrapperElement.style.overflow = zoomLevel < 1.0 ? 'visible' : 'hidden';
                                }
                                if (zoomLevelLabel) zoomLevelLabel.textContent = Math.round(zoomLevel * 100) + '%';
                            }

                            function fitToWidth() {
                                if (!wrapperElement) return;
                                const containerWidth = wrapperElement.clientWidth - 16;
                                const naturalWidth = cappedFlipWidth;
                                if (naturalWidth <= 0) return;
                                let target = containerWidth / naturalWidth;
                                if (target > 1) target = 1;
                                target = Math.max(ZOOM_MIN, Math.min(ZOOM_MAX, target));
                                applyZoom(target);
                            }

                            function toggleFullscreen() {
                                if (!document.fullscreenElement) {
                                    if (flipbookContainer.requestFullscreen) {
                                        flipbookContainer.requestFullscreen();
                                    } else if (flipbookContainer.webkitRequestFullscreen) {
                                        flipbookContainer.webkitRequestFullscreen();
                                    } else if (flipbookContainer.msRequestFullscreen) {
                                        flipbookContainer.msRequestFullscreen();
                                    }
                                } else {
                                    if (document.exitFullscreen) {
                                        document.exitFullscreen();
                                    } else if (document.webkitExitFullscreen) {
                                        document.webkitExitFullscreen();
                                    } else if (document.msExitFullscreen) {
                                        document.msExitFullscreen();
                                    }
                                }
                            }

                            if (zoomInBtn) zoomInBtn.addEventListener('click', () => applyZoom(zoomLevel + ZOOM_STEP));
                            if (zoomOutBtn) zoomOutBtn.addEventListener('click', () => applyZoom(zoomLevel - ZOOM_STEP));
                            if (zoomResetBtn) zoomResetBtn.addEventListener('click', () => applyZoom(1.0));
                            if (zoomFitBtn) zoomFitBtn.addEventListener('click', fitToWidth);
                            if (fullscreenBtn) fullscreenBtn.addEventListener('click', toggleFullscreen);

                            document.addEventListener('fullscreenchange', () => {
                                setTimeout(fitToWidth, 100);
                            });

                            // Keyboard shortcuts: + / = untuk zoom in, - untuk zoom out, 0 untuk reset, f untuk fit
                            document.addEventListener('keydown', (e) => {
                                // Abaikan jika user sedang mengetik di input/textarea
                                const tag = (e.target && e.target.tagName) || '';
                                if (tag === 'INPUT' || tag === 'TEXTAREA') return;
                                if (e.ctrlKey || e.metaKey || e.altKey) return;

                                if (e.key === '+' || e.key === '=') {
                                    e.preventDefault();
                                    applyZoom(zoomLevel + ZOOM_STEP);
                                } else if (e.key === '-' || e.key === '_') {
                                    e.preventDefault();
                                    applyZoom(zoomLevel - ZOOM_STEP);
                                } else if (e.key === '0') {
                                    e.preventDefault();
                                    applyZoom(1.0);
                                } else if (e.key === 'f' || e.key === 'F') {
                                    e.preventDefault();
                                    fitToWidth();
                                }
                            });

                            // Mouse wheel zoom (Ctrl + wheel) di area flipbook
                            wrapperElement.addEventListener('wheel', (e) => {
                                if (!e.ctrlKey) return;
                                e.preventDefault();
                                if (e.deltaY < 0) applyZoom(zoomLevel + ZOOM_STEP);
                                else applyZoom(zoomLevel - ZOOM_STEP);
                            }, { passive: false });

                            // Auto fit-to-width on initial load (mobile-friendly)
                            // Tunda sedikit agar layout settle
                            setTimeout(() => {
                                try { fitToWidth(); } catch (err) { /* ignore */ }
                            }, 50);

                            // Re-fit saat window berubah ukuran / orientation berubah
                            let resizeTimer = null;
                            const onResize = () => {
                                if (resizeTimer) clearTimeout(resizeTimer);
                                resizeTimer = setTimeout(() => {
                                    try { fitToWidth(); } catch (err) { /* ignore */ }
                                }, 120);
                            };
                            window.addEventListener('resize', onResize);
                            window.addEventListener('orientationchange', onResize);

                            console.log('[FLIPBOOK] Render complete:', {
                                numPages: pdfDoc.numPages,
                                pageFlipReady: true,
                                firstPageVisible: true,
                                zoomReady: true
                            });

                            // PDF sudah selesai dirender menjadi canvas dan PageFlip
                            // sudah aktif. Blob URL tidak lagi dibutuhkan oleh PDF.js
                            // (semua page object sudah di-decode), jadi aman di-revoke.
                            if (blobUrl) {
                                URL.revokeObjectURL(blobUrl);
                                blobUrl = null;
                                console.log('[FLIPBOOK] blobUrl revoked');
                            }

                            prevBtn.addEventListener('click', () => {
                                pageFlip.flipPrev();
                            });

                            nextBtn.addEventListener('click', () => {
                                pageFlip.flipNext();
                            });

                        } catch (error) {
                            console.error('[FLIPBOOK] PDF LOAD FAILED:', error);
                            console.error('[FLIPBOOK] URL:', url);
                            console.error('[FLIPBOOK] pdfjs version:', pdfjsLib.version);
                            console.error('[FLIPBOOK] workerSrc:', pdfjsLib.GlobalWorkerOptions.workerSrc);
                            loadingElement.style.display = 'none';
                            errorElement.textContent = 'Unable to load this magazine: ' + (error && error.message ? error.message : error);
                            errorElement.classList.remove('hidden');
                        }
                    })();
                </script>
            @endif

            <!-- Description under flipbook -->
            @if($magazine->description)
            <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 sm:p-8 space-y-3">
                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-align-left text-red-500"></i>
                    <span>Case Study // Deskripsi</span>
                </h2>
                <p class="text-gray-300 text-sm sm:text-base leading-relaxed whitespace-pre-line">{{ $magazine->description }}</p>
            </div>
            @endif

            <div class="pt-4 text-center">
                <a href="{{ route('portfolio.index') }}" class="inline-flex items-center space-x-2 bg-red-600 hover:bg-red-700 text-white px-8 py-3.5 rounded-xl font-bold shadow-lg transition">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>

        </div>
    </main>

</body>
</html>