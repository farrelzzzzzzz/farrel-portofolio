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
                @if($project->figma_url)
                <div class="space-y-4 pt-6">
                    <h3 class="text-2xl font-bold text-white flex items-center space-x-2">
                        <i class="fa-brands fa-figma text-indigo-400"></i>
                        <span>Figma Embed & Interactive Prototype Preview</span>
                    </h3>
                    <div class="relative w-full h-[600px] bg-darkBg border border-cardBorder rounded-3xl overflow-hidden shadow-2xl">
                        <iframe 
                            src="https://www.figma.com/embed?embed_host=share&url={{ urlencode($project->figma_url) }}" 
                            allowfullscreen 
                            class="w-full h-full border-0">
                        </iframe>
                    </div>
                </div>
                @endif
            </div>

            @if($project->gallery && count($project->gallery) > 0)
            <div class="space-y-4 pt-6">
                <h3 class="text-2xl font-bold text-white">Galeri Desain & Screenshot</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach($project->gallery as $img)
                    <div class="bg-cardBg border border-cardBorder rounded-2xl overflow-hidden aspect-video">
                        <img src="{{ $img }}" alt="Gallery item" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                    </div>
                    @endforeach
                </div>
            </div>
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
