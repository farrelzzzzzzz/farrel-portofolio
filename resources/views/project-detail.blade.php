<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $project->title }} — Farrel Balapradhana</title>
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
            <a href="/" class="text-xl font-bold text-white flex items-center space-x-2">
                <i class="fa-solid fa-arrow-left text-sm text-accentRed"></i>
                <span>Kembali ke Beranda</span>
            </a>
            <a href="/" class="text-2xl font-black tracking-wider text-white">FARREL<span class="text-accentRed">.</span></a>
        </div>
    </header>

    <main class="py-16 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-6">
            <div class="inline-flex items-center space-x-2 px-3 py-1 bg-accentRed/10 border border-accentRed/20 rounded-full text-accentRed text-xs font-bold uppercase tracking-widest">
                <span>{{ $project->category }}</span>
            </div>

            <h1 class="text-3xl sm:text-5xl font-black text-white leading-tight">{{ $project->title }}</h1>
            
            <p class="text-gray-400 text-lg leading-relaxed">{{ $project->short_description }}</p>

            <div class="relative overflow-hidden rounded-3xl border border-cardBorder shadow-2xl aspect-video my-8">
                <img src="{{ $project->thumbnail }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
            </div>

            @if($project->video_file)
            <div class="space-y-4 pt-6">
                <h3 class="text-2xl font-bold text-white flex items-center space-x-2">
                    <i class="fa-solid fa-video text-neonRed"></i>
                    <span>Live Video Playback</span>
                    <span class="ml-auto inline-flex items-center space-x-1.5 px-2.5 py-1 bg-neonRed/10 border border-neonRed/30 rounded-full text-[10px] font-mono font-bold text-neonRed uppercase tracking-wider">
                        <span class="w-1.5 h-1.5 rounded-full bg-neonRed animate-pulse"></span>
                        <span>HD Stream</span>
                    </span>
                </h3>
                <div class="relative w-full aspect-video bg-darkBg border border-cardBorder rounded-3xl overflow-hidden shadow-2xl">
                    <video controls class="w-full h-full object-cover">
                        <source src="{{ asset('storage/' . $project->video_file) }}" type="video/mp4">
                        Browser Anda tidak mendukung tag video.
                    </video>
                </div>
            </div>
            @endif

            @if($project->figma_url)
                @php
                    $figmaEmbedUrl = 'https://www.figma.com/embed?embed_host=share&url=' . urlencode($project->figma_url);
                @endphp
                <div class="space-y-4 pt-6">
                    <h3 class="text-2xl font-bold text-white flex items-center space-x-2">
                        <i class="fa-brands fa-figma text-indigo-400"></i>
                        <span>Interactive Figma Prototype</span>
                        <span class="ml-auto inline-flex items-center space-x-1.5 px-2.5 py-1 bg-indigo-500/10 border border-indigo-500/30 rounded-full text-[10px] font-mono font-bold text-indigo-300 uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
                            <span>Live Embed</span>
                        </span>
                    </h3>
                    <div class="relative w-full h-[400px] sm:h-[500px] md:h-[600px] bg-darkBg border border-cardBorder rounded-3xl overflow-hidden shadow-2xl">
                        <iframe
                            src="{{ $figmaEmbedUrl }}"
                            class="w-full h-full"
                            frameborder="0"
                            allowfullscreen
                            loading="lazy"
                            title="Figma Prototype — {{ $project->title }}">
                        </iframe>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-xs text-gray-400 px-2">
                        <span class="flex items-center space-x-2">
                            <i class="fa-solid fa-hand-pointer text-indigo-400"></i>
                            <span>Prototipe interaktif langsung dari Figma — klik, scroll, dan zoom untuk eksplorasi.</span>
                        </span>
                        <a href="{{ $project->figma_url }}" target="_blank" rel="noopener noreferrer" class="text-indigo-400 hover:text-indigo-300 font-semibold flex items-center space-x-1.5 transition shrink-0">
                            <i class="fa-brands fa-figma"></i>
                            <span>Open in Figma</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                    </div>
                </div>
            @endif

            @if($project->model_file)
            <div class="space-y-4 pt-6">
                <h3 class="text-2xl font-bold text-white flex items-center space-x-2">
                    <i class="fa-solid fa-cube text-accentRed"></i>
                    <span>Interactive 3D Model Viewer (Three.js)</span>
                </h3>
                <div class="relative w-full h-[500px] bg-darkBg border border-cardBorder rounded-3xl overflow-hidden shadow-2xl flex items-center justify-center" id="three-container">
                    <div id="three-loading" class="text-gray-400 text-sm flex items-center space-x-2">
                        <i class="fa-solid fa-spinner fa-spin text-accentRed"></i>
                        <span>Memuat model 3D...</span>
                    </div>
                </div>
                <div class="flex items-center justify-between text-xs text-gray-400 px-2">
                    <span>Gunakan klik & drag untuk rotate, scroll untuk zoom.</span>
                    <a href="{{ $project->model_file }}" download class="text-accentRed hover:underline font-semibold flex items-center space-x-1">
                        <i class="fa-solid fa-download"></i>
                        <span>Download File 3D (.obj / .blend)</span>
                    </a>
                </div>
            </div>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/OBJLoader.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/STLLoader.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>
            <script>
                const modelUrl = "{{ $project->model_file }}";
                const container = document.getElementById('three-container');
                const loading = document.getElementById('three-loading');

                // Fallback / Generic shape or OBJ Loader
                const scene = new THREE.Scene();
                scene.background = new THREE.Color(0x0b0b0f);

                const camera = new THREE.PerspectiveCamera(45, container.clientWidth / container.clientHeight, 0.1, 1000);
                camera.position.set(0, 5, 10);

                const renderer = new THREE.WebGLRenderer({ antialias: true });
                renderer.setSize(container.clientWidth, container.clientHeight);
                renderer.setPixelRatio(window.devicePixelRatio);
                container.appendChild(renderer.domElement);

                const controls = new THREE.OrbitControls(camera, renderer.domElement);
                controls.enableDamping = true;
                controls.dampingFactor = 0.05;

                const ambientLight = new THREE.AmbientLight(0xffffff, 1.2);
                scene.add(ambientLight);

                const directionalLight = new THREE.DirectionalLight(0xffffff, 2);
                directionalLight.position.set(5, 10, 7);
                scene.add(directionalLight);

                const gridHelper = new THREE.GridHelper(20, 20, 0xe50914, 0x232330);
                gridHelper.position.y = -1;
                scene.add(gridHelper);

                function initAnimate() {
                    function animate() {
                        requestAnimationFrame(animate);
                        controls.update();
                        renderer.render(scene, camera);
                    }
                    animate();
                }

                // Always allow downloading original source file alongside viewer
                let downloadBtnHtml = '<div class="mt-3"><a href="' + modelUrl + '" download class="inline-flex items-center space-x-2 px-4 py-2 bg-cardBorder text-white text-xs font-semibold rounded-xl hover:bg-accentRed transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg><span>Download File Asli (.blend / .obj / .glb)</span></a></div>';

                // Handle .blend or direct warning / info for non-web 3D source files
                if (modelUrl.toLowerCase().endsWith('.blend')) {
                    showViewerError('File .blend adalah format proyek native Blender dan tidak dapat dirender langsung oleh browser. Silakan download file atau upload versi .glb / .obj.', modelUrl);
                } else if (modelUrl.toLowerCase().endsWith('.glb') || modelUrl.toLowerCase().endsWith('.gltf') || modelUrl.toLowerCase().includes('glb')) {
                    const loader = new THREE.GLTFLoader();
                    loader.load(modelUrl, function (gltf) {
                        loading.style.display = 'none';
                        const object = gltf.scene || gltf.scenes[0];
                        
                        const box = new THREE.Box3().setFromObject(object);
                        const center = box.getCenter(new THREE.Vector3());
                        
                        object.position.x -= center.x;
                        object.position.y -= center.y;
                        object.position.z -= center.z;

                        scene.add(object);
                        initAnimate();
                    }, undefined, function (error) {
                        console.error('GLTFLoader error:', error);
                        // If GLTFLoader fails on .blend URL (e.g. if blender cli didn't run or file is raw blend), fallback to showing friendly message with download
                        if (modelUrl.toLowerCase().endsWith('.blend') || modelUrl.toLowerCase().includes('.blend')) {
                            showViewerError('File .blend tersimpan sebagai sumber. Mohon upload versi .glb atau .obj untuk preview 3D interaktif.', modelUrl);
                        } else {
                            showViewerError('Gagal memproses file GLB/GLTF. Pastikan file valid.', modelUrl);
                        }
                    });
                } else if (modelUrl.toLowerCase().endsWith('.stl') || modelUrl.toLowerCase().includes('stl')) {
                    const loader = new THREE.STLLoader();
                    loader.load(modelUrl, function (geometry) {
                        loading.style.display = 'none';
                        geometry.computeVertexNormals();
                        const material = new THREE.MeshStandardMaterial({
                            color: 0xcccccc,
                            roughness: 0.4,
                            metalness: 0.2
                        });
                        const mesh = new THREE.Mesh(geometry, material);
                        
                        geometry.computeBoundingBox();
                        const center = geometry.boundingBox.getCenter(new THREE.Vector3());
                        mesh.position.sub(center);

                        scene.add(mesh);
                        initAnimate();
                    }, undefined, function (error) {
                        console.error('STLLoader error:', error);
                        showViewerError('Gagal memproses file STL.', modelUrl);
                    });
                } else {
                    const loader = new THREE.OBJLoader();
                    loader.load(modelUrl, function (object) {
                        loading.style.display = 'none';
                        object.traverse(function (child) {
                            if (child.isMesh) {
                                child.material = new THREE.MeshStandardMaterial({
                                    color: 0xcccccc,
                                    roughness: 0.4,
                                    metalness: 0.2
                                });
                            }
                        });
                        
                        const box = new THREE.Box3().setFromObject(object);
                        const center = box.getCenter(new THREE.Vector3());
                        
                        object.position.x -= center.x;
                        object.position.y -= center.y;
                        object.position.z -= center.z;

                        scene.add(object);
                        initAnimate();
                    }, undefined, function (error) {
                        console.error('OBJLoader error:', error);
                        showViewerError('Gagal memproses file OBJ.', modelUrl);
                    });
                }

                function showViewerError(message, downloadUrl) {
                    loading.innerHTML = '<div class="absolute inset-0 bg-darkBg/95 backdrop-blur-md flex items-center justify-center z-20 p-6 text-center"><div class="max-w-md bg-cardBg border border-cardBorder rounded-2xl p-6 shadow-2xl"><svg class="w-10 h-10 mx-auto text-accentRed mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.56c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg><h3 class="text-white font-semibold text-sm mb-1">Gagal Memuat Model 3D</h3><p class="text-gray-400 text-xs mb-4">' + message + '</p>' + (downloadUrl ? '<a href="' + downloadUrl + '" download class="inline-flex items-center space-x-2 px-4 py-2 bg-accentRed text-white text-xs font-semibold rounded-xl hover:bg-red-700 transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg><span>Download File Asli (.blend / .obj / .glb)</span></a>' : '') + '</div></div>';
                }

                function centerAndScaleModel(object) {
                    const box = new THREE.Box3().setFromObject(object);
                    const center = box.getCenter(new THREE.Vector3());
                    const size = box.getSize(new THREE.Vector3());

                    const maxDim = Math.max(size.x, size.y, size.z);
                    if (maxDim > 0) {
                        const scaleFactor = 4 / maxDim;
                        object.scale.set(scaleFactor, scaleFactor, scaleFactor);
                    }

                    const boxScaled = new THREE.Box3().setFromObject(object);
                    const centerScaled = boxScaled.getCenter(new THREE.Vector3());
                    object.position.x -= centerScaled.x;
                    object.position.y -= centerScaled.y - (size.y * object.scale.y / 2);
                    object.position.z -= centerScaled.z;

                    scene.add(object);
                    loading.style.display = 'none';
                }
            </script>
            @endif

            <div class="bg-cardBg border border-cardBorder rounded-2xl p-8 space-y-4">
                <h3 class="text-xl font-bold text-white border-b border-cardBorder pb-3">Deskripsi Proyek & Case Study</h3>
                <div class="text-gray-300 leading-relaxed space-y-4 text-base">
                    <p>{{ $project->description }}</p>
                </div>
            </div>

            @if(!empty($project->pdf_file))
            @php
                $resolvedPdfUrl = str_starts_with($project->pdf_file, 'http') ? $project->pdf_file : asset('storage/' . ltrim($project->pdf_file, '/'));
            @endphp
            <div class="space-y-4 pt-6" id="magazine-flipbook-section">
                <h3 class="text-2xl font-bold text-white flex items-center space-x-2">
                    <i class="fa-solid fa-book-open text-accentRed"></i>
                    <span>Interactive Magazine Flipbook Viewer</span>
                </h3>
                <div class="relative w-full bg-darkBg border border-cardBorder rounded-3xl overflow-hidden shadow-2xl p-4 sm:p-8 flex flex-col items-center justify-center min-h-[600px]" id="flipbook-container">
                    <div id="flipbook-loading" class="text-gray-400 text-sm flex flex-col items-center space-y-3 py-20">
                        <i class="fa-solid fa-spinner fa-spin text-accentRed text-3xl"></i>
                        <span class="font-semibold text-white">Merender halaman PDF Magazine...</span>
                        <span class="text-xs text-gray-500 font-mono break-all max-w-md text-center">{{ $resolvedPdfUrl }}</span>
                    </div>
                    <div id="flipbook-viewport" class="transition-transform duration-200 flex items-center justify-center w-full overflow-hidden py-4" style="min-height: 520px; display: flex;">
                        <div id="book" style="display: none; margin: 0 auto; min-width: 300px; min-height: 400px;"></div>
                    </div>
                    <div id="flipbook-error" class="text-red-400 text-sm py-10 text-center px-4" style="display:none;">
                        <p class="font-bold mb-1 text-base">Gagal memuat file PDF magazine.</p>
                        <p class="text-xs text-gray-400 font-mono break-all" id="error-url-display"></p>
                    </div>
                </div>

                <!-- Flipbook Controls Toolbar -->
                <div class="bg-cardBorder/30 border border-cardBorder rounded-2xl p-4 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center space-x-2">
                        <button type="button" onclick="prevPage()" class="px-4 py-2 bg-cardBg border border-cardBorder hover:border-accentRed text-white text-xs font-bold rounded-xl transition">
                            <i class="fa-solid fa-arrow-left mr-1"></i> Previous
                        </button>
                        <span id="page-info" class="text-xs text-gray-400 font-mono px-2">Memuat halaman...</span>
                        <button type="button" onclick="nextPage()" class="px-4 py-2 bg-cardBg border border-cardBorder hover:border-accentRed text-white text-xs font-bold rounded-xl transition">
                            Next <i class="fa-solid fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button type="button" onclick="zoomIn()" class="px-3 py-2 bg-cardBg border border-cardBorder hover:border-accentRed text-white text-xs font-bold rounded-xl transition">
                            <i class="fa-solid fa-magnifying-glass-plus"></i> Zoom +
                        </button>
                        <button type="button" onclick="zoomOut()" class="px-3 py-2 bg-cardBg border border-cardBorder hover:border-accentRed text-white text-xs font-bold rounded-xl transition">
                            <i class="fa-solid fa-magnifying-glass-minus"></i> Zoom -
                        </button>
                        <button type="button" onclick="toggleFullscreen()" class="px-3 py-2 bg-cardBg border border-cardBorder hover:border-accentRed text-white text-xs font-bold rounded-xl transition">
                            <i class="fa-solid fa-expand"></i> Fullscreen
                        </button>
                        <a href="{{ $resolvedPdfUrl }}" download class="px-3 py-2 bg-accentRed text-white text-xs font-bold rounded-xl hover:bg-red-700 transition flex items-center space-x-1">
                            <i class="fa-solid fa-download"></i>
                            <span>PDF</span>
                        </a>
                    </div>
                </div>
            </div>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/page-flip@2.0.7/dist/js/page-flip.browser.js"></script>
            <script>
                if (window.pdfjsLib) {
                    window.pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
                }

                const magazinePdfUrl = "{{ $resolvedPdfUrl }}";
                console.log("Active Magazine PDF URL:", magazinePdfUrl);

                let pageFlipInstance = null;
                let currentScale = 1.0;

                async function initMagazineFlipbook() {
                    const bookElem = document.getElementById('book');
                    const loadingElem = document.getElementById('flipbook-loading');
                    const errorElem = document.getElementById('flipbook-error');
                    const errorUrlDisplay = document.getElementById('error-url-display');

                    if (!magazinePdfUrl) {
                        if (loadingElem) loadingElem.style.display = 'none';
                        if (errorElem) errorElem.style.display = 'block';
                        if (errorUrlDisplay) errorUrlDisplay.innerText = "URL PDF Kosong";
                        return;
                    }

                    try {
                        const loadingTask = pdfjsLib.getDocument({
                            url: magazinePdfUrl,
                            cMapUrl: 'https://cdn.jsdelivr.net/npm/pdfjs-dist@3.11.174/cmaps/',
                            cMapPacked: true,
                        });
                        const pdfDoc = await loadingTask.promise;
                        const totalPages = pdfDoc.numPages;

                        bookElem.innerHTML = '';
                        const isMobile = window.innerWidth < 768;

                        for (let i = 1; i <= totalPages; i++) {
                            const page = await pdfDoc.getPage(i);
                            const viewport = page.getViewport({ scale: 1.5 });

                            const canvas = document.createElement('canvas');
                            const context = canvas.getContext('2d');
                            canvas.height = viewport.height;
                            canvas.width = viewport.width;

                            await page.render({ canvasContext: context, viewport: viewport }).promise;

                            const pageDiv = document.createElement('div');
                            pageDiv.className = 'page bg-white shadow-xl overflow-hidden flex items-center justify-center';
                            // Set explicit width and height on pageDiv so StPageFlip can measure them correctly
                            pageDiv.style.width = viewport.width + 'px';
                            pageDiv.style.height = viewport.height + 'px';
                            pageDiv.appendChild(canvas);
                            bookElem.appendChild(pageDiv);
                        }

                        if (loadingElem) loadingElem.style.display = 'none';
                        bookElem.style.display = 'block';

                        // Calculate aspect ratio or provide flexible dimensions based on first rendered page
                        const firstPageSample = bookElem.querySelector('.page canvas');
                        const pWidth = firstPageSample ? firstPageSample.width / 1.5 : (isMobile ? 320 : 450);
                        const pHeight = firstPageSample ? firstPageSample.height / 1.5 : (isMobile ? 450 : 620);

                        pageFlipInstance = new St.PageFlip(bookElem, {
                            width: Math.round(pWidth),
                            height: Math.round(pHeight),
                            size: 'fixed',
                            minWidth: 200,
                            maxWidth: 1000,
                            minHeight: 300,
                            maxHeight: 1200,
                            maxShadowOpacity: 0.5,
                            showCover: true,
                            mobileScrollSupport: true
                        });

                        pageFlipInstance.loadFromHTML(bookElem.querySelectorAll('.page'));

                        pageFlipInstance.on('flip', (e) => {
                            const info = document.getElementById('page-info');
                            if (info) info.innerText = `Halaman ${e.data + 1} dari ${totalPages}`;
                        });

                        const info = document.getElementById('page-info');
                        if (info) info.innerText = `Halaman 1 dari ${totalPages}`;

                    } catch (err) {
                        console.error('Flipbook load error:', err);
                        if (loadingElem) loadingElem.style.display = 'none';
                        if (errorElem) errorElem.style.display = 'block';
                        if (errorUrlDisplay) errorUrlDisplay.innerText = "URL: " + magazinePdfUrl + " | Error: " + err.message;
                    }
                }

                function nextPage() {
                    if (pageFlipInstance) pageFlipInstance.flipNext();
                }

                function prevPage() {
                    if (pageFlipInstance) pageFlipInstance.flipPrev();
                }

                function zoomIn() {
                    currentScale += 0.2;
                    const viewport = document.getElementById('flipbook-viewport');
                    if (viewport) viewport.style.transform = `scale(${currentScale})`;
                }

                function zoomOut() {
                    if (currentScale > 0.6) {
                        currentScale -= 0.2;
                        const viewport = document.getElementById('flipbook-viewport');
                        if (viewport) viewport.style.transform = `scale(${currentScale})`;
                    }
                }

                function toggleFullscreen() {
                    const container = document.getElementById('magazine-flipbook-section');
                    if (!document.fullscreenElement && container) {
                        container.requestFullscreen().catch(err => {
                            console.error('Fullscreen error:', err);
                        });
                    } else if (document.fullscreenElement) {
                        document.exitFullscreen();
                    }
                }

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initMagazineFlipbook);
                } else {
                    initMagazineFlipbook();
                }
            </script>
            @endif

            <div class="pt-8 text-center">
                <a href="/" class="inline-flex items-center space-x-2 bg-accentRed hover:bg-accentRedHover text-white px-8 py-3.5 rounded-xl font-bold shadow-lg shadow-accentRed/30 transition">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Kembali ke Portofolio Utama</span>
                </a>
            </div>
        </div>
    </main>

</body>
</html>
