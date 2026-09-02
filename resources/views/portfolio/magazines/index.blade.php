<!-- Magazines Section in Portfolio -->
<div class="py-12 bg-gray-900 text-white border-t border-gray-800" id="magazines-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold tracking-tight sm:text-4xl">Magazines & Publications</h2>
            <p class="mt-3 text-lg text-gray-400">Explore interactive 3D flipbook publications.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $portfolioMagazines = \App\Models\Magazine::latest()->get();
            @endphp
            @forelse($portfolioMagazines as $mag)
                <div class="bg-gray-800 rounded-xl overflow-hidden shadow-2xl border border-gray-700 flex flex-col justify-between">
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">{{ $mag->title }}</h3>
                        <p class="text-gray-400 text-sm mb-6">{{ $mag->description }}</p>
                    </div>
                    <div class="p-6 pt-0">
                        <button onclick="openFlipbook('{{ asset('storage/' . $mag->pdf_path) }}', '{{ addslashes($mag->title) }}')" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition duration-200 shadow-md">
                            Read Flipbook
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12 text-gray-500">
                    No magazines published yet.
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Flipbook Modal Viewer -->
<div id="flipbook-modal" class="fixed inset-0 z-50 bg-black bg-opacity-95 hidden flex flex-col items-center justify-center">
    <div class="w-full flex justify-between items-center px-6 py-4 bg-gray-900 border-b border-gray-800">
        <h2 id="flipbook-title" class="text-lg font-bold text-white truncate max-w-md"></h2>
        <div class="flex items-center space-x-3 sm:space-x-4">
            <button onclick="zoomIn()" class="px-3 py-1 bg-gray-800 hover:bg-gray-700 rounded text-sm">Zoom +</button>
            <button onclick="zoomOut()" class="px-3 py-1 bg-gray-800 hover:bg-gray-700 rounded text-sm">Zoom -</button>
            <button onclick="toggleFullscreen()" class="px-3 py-1 bg-gray-800 hover:bg-gray-700 rounded text-sm hidden sm:inline-block">Fullscreen</button>
            <a id="download-btn" href="#" download class="px-3 py-1 bg-indigo-600 hover:bg-indigo-700 rounded text-sm">Download PDF</a>
            <button onclick="closeFlipbook()" class="text-red-500 hover:text-red-400 font-bold text-2xl px-2">✕</button>
        </div>
    </div>

    <div id="viewer-container" class="flex-1 w-full flex items-center justify-center overflow-auto relative p-2 sm:p-8">
        <div id="flipbook-viewport" class="transition-transform duration-200 flex items-center justify-center">
            <div id="book"></div>
        </div>
    </div>

    <div class="py-4 bg-gray-900 w-full flex justify-center space-x-6 items-center border-t border-gray-800">
        <button onclick="prevPage()" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 rounded text-sm font-medium">Previous</button>
        <span id="page-info" class="text-sm text-gray-300">Loading...</span>
        <button onclick="nextPage()" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 rounded text-sm font-medium">Next</button>
    </div>
</div>

<!-- PDF.js & StPageFlip CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/page-flip@2.0.7/dist/js/page-flip.browser.js"></script>

<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    let pageFlip = null;
    let currentZoom = 1;

    async function openFlipbook(pdfUrl, title) {
        document.getElementById('flipbook-title').innerText = title;
        document.getElementById('download-btn').href = pdfUrl;
        document.getElementById('flipbook-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        const bookElem = document.getElementById('book');
        bookElem.innerHTML = '<div class="text-white text-center py-20">Rendering PDF pages...</div>';

        try {
            const loadingTask = pdfjsLib.getDocument(pdfUrl);
            const pdf = await loadingTask.promise;
            const totalPages = pdf.numPages;

            bookElem.innerHTML = '';
            const isMobile = window.innerWidth < 768;

            for (let i = 1; i <= totalPages; i++) {
                const page = await pdf.getPage(i);
                const viewport = page.getViewport({ scale: 1.5 });

                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                await page.render({ canvasContext: context, viewport: viewport }).promise;

                const pageDiv = document.createElement('div');
                pageDiv.className = 'page bg-white shadow-md';
                pageDiv.appendChild(canvas);
                bookElem.appendChild(pageDiv);
            }

            if (pageFlip) {
                pageFlip.destroy();
            }

            pageFlip = new St.PageFlip(bookElem, {
                width: isMobile ? 320 : 450,
                height: isMobile ? 450 : 600,
                size: isMobile ? 'fixed' : 'stretch',
                minWidth: 280,
                maxWidth: 600,
                minHeight: 400,
                maxHeight: 800,
                maxShadowOpacity: 0.5,
                showCover: true,
                mobileScrollSupport: true
            });

            pageFlip.loadFromHTML(document.querySelectorAll('.page'));

            pageFlip.on('flip', (e) => {
                document.getElementById('page-info').innerText = `Page ${e.data + 1} of ${totalPages}`;
            });

            document.getElementById('page-info').innerText = `Page 1 of ${totalPages}`;
        } catch (error) {
            console.error('Error loading PDF:', error);
            bookElem.innerHTML = '<div class="text-red-500 text-center py-20">Failed to load PDF. Please try downloading instead.</div>';
        }
    }

    function closeFlipbook() {
        document.getElementById('flipbook-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        if (pageFlip) {
            pageFlip.destroy();
            pageFlip = null;
        }
    }

    function nextPage() {
        if (pageFlip) pageFlip.flipNext();
    }

    function prevPage() {
        if (pageFlip) pageFlip.flipPrev();
    }

    function zoomIn() {
        currentZoom += 0.2;
        document.getElementById('flipbook-viewport').style.transform = `scale(${currentZoom})`;
    }

    function zoomOut() {
        if (currentZoom > 0.6) {
            currentZoom -= 0.2;
            document.getElementById('flipbook-viewport').style.transform = `scale(${currentZoom})`;
        }
    }

    function toggleFullscreen() {
        const elem = document.getElementById('flipbook-modal');
        if (!document.fullscreenElement) {
            elem.requestFullscreen().catch(err => {
                alert(`Error attempting to enable fullscreen: ${err.message}`);
            });
        } else {
            document.exitFullscreen();
        }
    }
</script>
