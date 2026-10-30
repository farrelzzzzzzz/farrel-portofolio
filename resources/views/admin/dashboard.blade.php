@extends('admin.layouts.app')

@section('content')
<div class="admin-dashboard">
    <style>
        .admin-dashboard {
            background-color: #050507;
            color: #d4d4d8;
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            min-height: calc(100vh - 73px);
            padding: 1.5rem 1rem 4rem 1.0rem;
            overflow-x: hidden;
        }
        @media (min-width: 1024px) {
            .admin-dashboard {
                padding: 4rem 3rem 8rem 3rem;
            }
        }
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            box-sizing: border-box;
        }
        .admin-hero {
            margin-bottom: 2rem;
            border-bottom: 1px solid #202027;
            padding-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-direction: column;
            flex-wrap: wrap;
            gap: 1rem;
        }
        @media (min-width: 768px) {
            .admin-hero {
                flex-direction: row;
                align-items: flex-end;
                margin-bottom: 3rem;
                padding-bottom: 2rem;
            }
        }
        .admin-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: #e50914;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }
        .admin-badge-dot {
            width: 6px;
            height: 6px;
            background-color: #e50914;
            border-radius: 50%;
            box-shadow: 0 0 8px #e50914;
        }
        .admin-title {
            font-size: clamp(2rem, 3.5vw, 2.75rem);
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.03em;
            margin: 0;
        }
        .admin-subtitle {
            color: #8b8b94;
            font-size: 1rem;
            margin-top: 0.5rem;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
            margin-bottom: 2rem;
        }
        @media (min-width: 640px) {
            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 1rem;
            }
        }
        @media (min-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                margin-bottom: 3rem;
            }
        }
        .stat-card {
            background-color: #09090d;
            border: 1px solid #202027;
            border-radius: 12px;
            padding: 1.25rem;
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            border-color: #e50914;
            transform: translateY(-2px);
        }
        .stat-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #8b8b94;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        .stat-value {
            font-size: 1.75rem;
            font-weight: 800;
            color: #ffffff;
        }

        /* Quick Upload Actions */
        .section-header {
            font-size: 1.25rem;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .quick-upload-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
            margin-bottom: 2.5rem;
        }
        @media (min-width: 640px) {
            .quick-upload-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 1rem;
            }
        }
        @media (min-width: 1024px) {
            .quick-upload-grid {
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
                margin-bottom: 4rem;
            }
        }
        .quick-btn {
            background-color: #09090d;
            border: 1px solid #202027;
            border-radius: 10px;
            padding: 1.25rem 1rem;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.9rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        .quick-btn:hover {
            background-color: #13131a;
            border-color: #e50914;
            color: #e50914;
            box-shadow: 0 4px 20px rgba(229, 9, 20, 0.15);
        }
        .quick-btn svg {
            width: 24px;
            height: 24px;
            color: #e50914;
        }

        /* Modal Forms */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(5, 5, 7, 0.85);
            backdrop-filter: blur(8px);
            z-index: 100;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            overflow-y: auto;
            box-sizing: border-box;
        }
        .modal-overlay.active {
            display: flex;
        }
        .modal-box {
            background-color: #09090d;
            border: 1px solid #25252d;
            border-radius: 14px;
            width: 100%;
            max-width: 650px;
            max-height: calc(100vh - 2rem);
            overflow-y: auto;
            padding: 1.25rem;
            box-sizing: border-box;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
        }
        @media (min-width: 640px) {
            .modal-box {
                padding: 2rem;
                max-height: 90vh;
            }
            .modal-overlay {
                padding: 1.5rem;
            }
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #202027;
            padding-bottom: 1rem;
        }
        .modal-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #ffffff;
            margin: 0;
        }
        .modal-close {
            background: none;
            border: none;
            color: #8b8b94;
            font-size: 1.5rem;
            cursor: pointer;
            transition: color 0.2s;
        }
        .modal-close:hover {
            color: #ffffff;
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 1.25rem;
        }
        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #d4d4d8;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .form-input, .form-select, .form-textarea {
            width: 100%;
            background-color: #0b0b0f;
            border: 1px solid #25252d;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            color: #ffffff;
            font-size: 0.95rem;
            font-family: inherit;
            transition: border-color 0.2s;
            box-sizing: border-box;
        }
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #e50914;
            box-shadow: 0 0 0 2px rgba(229, 9, 20, 0.15);
        }
        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }
        .form-hint {
            font-size: 0.75rem;
            color: #8b8b94;
            margin-top: 0.35rem;
        }
        .btn-submit {
            background-color: #e50914;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 0.85rem 1.75rem;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s;
            width: 100%;
            margin-top: 1rem;
        }
        .btn-submit:hover {
            background-color: #f40612;
            box-shadow: 0 4px 20px rgba(229, 9, 20, 0.4);
        }

        /* Asset Filter & List */
        .filter-bar {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }
        .filter-btn {
            background-color: #09090d;
            border: 1px solid #202027;
            border-radius: 6px;
            padding: 0.5rem 1rem;
            color: #8b8b94;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }
        .filter-btn:hover, .filter-btn.active {
            background-color: #e50914;
            border-color: #e50914;
            color: #ffffff;
        }

        .assets-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        @media (min-width: 640px) {
            .assets-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 1.5rem;
            }
        }
        .asset-card {
            background-color: #09090d;
            border: 1px solid #202027;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        .asset-card:hover {
            border-color: #353542;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .asset-thumb {
            width: 100%;
            height: 160px;
            object-fit: cover;
            background-color: #13131a;
            border-bottom: 1px solid #202027;
        }
        .asset-body {
            padding: 1.25rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .asset-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        .asset-badge {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            background-color: #1c1c24;
            color: #e50914;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-weight: 700;
        }
        .asset-date {
            font-size: 0.75rem;
            color: #8b8b94;
        }
        .asset-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #ffffff;
            margin: 0 0 1rem 0;
        }
        .asset-actions {
            display: flex;
            gap: 0.5rem;
            border-top: 1px solid #202027;
            padding-top: 1rem;
            margin-top: auto;
        }
        .btn-action {
            flex: 1;
            background-color: #13131a;
            border: 1px solid #25252d;
            border-radius: 6px;
            padding: 0.5rem;
            color: #d4d4d8;
            font-size: 0.8rem;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-action:hover {
            background-color: #202027;
            color: #ffffff;
            border-color: #3f3f46;
        }
        .btn-delete {
            background-color: rgba(229, 9, 20, 0.1);
            border-color: rgba(229, 9, 20, 0.3);
            color: #ff5252;
        }
        .btn-delete:hover {
            background-color: #e50914;
            color: #ffffff;
            border-color: #e50914;
        }
        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #34d399;
            padding: 1rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }
    </style>

    <div class="admin-container">
        <!-- Hero Section -->
        <div class="admin-hero">
            <div>
                <div class="admin-badge">
                    <span class="admin-badge-dot"></span>
                    Asset Management Center
                </div>
                <h1 class="admin-title">Dashboard & Assets</h1>
                <p class="admin-subtitle">Manage and publish all portfolio media assets across 6 specialized categories.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Statistics Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Assets</div>
                <div class="stat-value">{{ $stats['total'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">3D Design</div>
                <div class="stat-value">{{ $stats['3d'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Images</div>
                <div class="stat-value">{{ $stats['image'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Videos</div>
                <div class="stat-value">{{ $stats['video'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Figma</div>
                <div class="stat-value">{{ $stats['figma'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Magazines</div>
                <div class="stat-value">{{ $stats['magazine'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Certificates</div>
                <div class="stat-value">{{ $stats['certificate'] }}</div>
            </div>
        </div>

        <!-- Quick Upload Section -->
        <div style="margin-bottom: 3rem;">
            <div class="section-header">
                <span>Quick Upload / Add Asset</span>
            </div>
            <div class="quick-upload-grid">
                <button type="button" class="quick-btn" onclick="openModal('modal-3d')">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    + Add 3D
                </button>
                <button type="button" class="quick-btn" onclick="openModal('modal-image')">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    + Add Image
                </button>
                <button type="button" class="quick-btn" onclick="openModal('modal-video')">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    + Add Video
                </button>
                <button type="button" class="quick-btn" onclick="openModal('modal-figma')">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    + Add Figma
                </button>
                <button type="button" class="quick-btn" onclick="openModal('modal-canva')">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    + Add Canva
                </button>
                <button type="button" class="quick-btn" onclick="openModal('modal-magazine')">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    + Add Magazine
                </button>
                <button type="button" class="quick-btn" onclick="openModal('modal-certificate')">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    + Add Cert
                </button>
            </div>
        </div>

        <!-- Recent Assets & Filter -->
        <div>
            <div class="section-header">
                <span>Recent Assets & Gallery</span>
            </div>
            
            <div class="filter-bar">
                <button type="button" class="filter-btn active" onclick="filterAssets('all')">All Assets</button>
                <button type="button" class="filter-btn" onclick="filterAssets('3d')">3D Design</button>
                <button type="button" class="filter-btn" onclick="filterAssets('image')">Images</button>
                <button type="button" class="filter-btn" onclick="filterAssets('video')">Videos</button>
                <button type="button" class="filter-btn" onclick="filterAssets('figma')">Figma</button>
                <button type="button" class="filter-btn" onclick="filterAssets('canva')">Canva</button>
                <button type="button" class="filter-btn" onclick="filterAssets('magazine')">Magazines</button>
                <button type="button" class="filter-btn" onclick="filterAssets('certificate')">Certificates</button>
            </div>

            <div class="assets-grid">
                <!-- Projects Loop -->
                @foreach($projects as $proj)
                    @php
                        $catLower = strtolower($proj->category ?? '');
                        $typeKey = 'image';
                        $badgeText = 'Image';
                        if(str_contains($catLower, '3d')) { $typeKey = '3d'; $badgeText = '3D Model'; }
                        elseif(str_contains($catLower, 'animation') || $proj->video_file) { $typeKey = 'video'; $badgeText = 'Video'; }
                        elseif(str_contains($catLower, 'ui/ux') || $proj->figma_url) { $typeKey = 'figma'; $badgeText = 'Figma'; }
                        elseif(str_contains($catLower, 'canva') || $proj->canva_url) { $typeKey = 'canva'; $badgeText = 'Canva'; }
                        elseif(str_contains($catLower, 'web')) { $typeKey = 'image'; $badgeText = 'Web'; }
                    @endphp
                    <div class="asset-card" data-type="{{ $typeKey }}">
                        @if($proj->thumbnail)
                            <img src="{{ $proj->thumbnail }}" class="asset-thumb" alt="{{ $proj->title }}">
                        @else
                            <div class="asset-thumb" style="display:flex;align-items:center;justify-content:center;color:#52525b;font-size:0.75rem;background:#13131a;">No thumbnail</div>
                        @endif
                        <div class="asset-body">
                            <div>
                                <div class="asset-meta">
                                    <span class="asset-badge">{{ $badgeText }}</span>
                                    <span class="asset-date">{{ $proj->created_at->format('M d, Y') }}</span>
                                </div>
                                <h3 class="asset-title">{{ $proj->title }}</h3>
                            </div>
                            <div class="asset-actions">
                                <a href="{{ route('project.show', $proj->slug) }}" target="_blank" class="btn-action">View</a>
                                <a href="{{ route('admin.projects.edit', $proj) }}" class="btn-action">Edit</a>
                                <form action="{{ route('admin.projects.destroy', $proj) }}" method="POST" onsubmit="return confirm('Delete this project?');" style="flex: 1; display: flex;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" style="width: 100%;">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Magazines Loop -->
                @foreach($magazines as $mag)
                    <div class="asset-card" data-type="magazine">
                        @if($mag->cover_image_path)
                            <img src="{{ preg_match('#^https?://#i', $mag->cover_image_path) ? $mag->cover_image_path : asset('storage/' . ltrim($mag->cover_image_path, '/')) }}" class="asset-thumb" alt="{{ $mag->title }}">
                        @else
                            <div class="asset-thumb" style="display:flex;align-items:center;justify-content:center;color:#52525b;font-size:0.75rem;background:#13131a;">No cover</div>
                        @endif
                        <div class="asset-body">
                            <div>
                                <div class="asset-meta">
                                    <span class="asset-badge">Magazine</span>
                                    <span class="asset-date">{{ $mag->created_at->format('M d, Y') }}</span>
                                </div>
                                <h3 class="asset-title">{{ $mag->title }}</h3>
                            </div>
                            <div class="asset-actions">
                                <a href="{{ route('magazine.show', $mag->id) }}" target="_blank" class="btn-action">View</a>
                                <a href="{{ route('admin.magazines.edit', $mag) }}" class="btn-action">Edit</a>
                                <form action="{{ route('admin.magazines.destroy', $mag->id) }}" method="POST" onsubmit="return confirm('Delete this magazine?');" style="flex: 1; display: flex;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" style="width: 100%;">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Certificates Loop -->
                @foreach($certificates as $cert)
                    <div class="asset-card" data-type="certificate">
                        @if($cert->image)
                            <img src="{{ $cert->image }}" class="asset-thumb" alt="{{ $cert->title }}">
                        @elseif($cert->pdf_file || isset($cert->pdf_path))
                            <div class="asset-thumb relative bg-obsidian flex items-center justify-center overflow-hidden">
                                <canvas class="cert-pdf-canvas w-full h-full object-contain" data-pdf="{{ asset('storage/' . ($cert->pdf_file ?? $cert->pdf_path)) }}"></canvas>
                            </div>
                        @else
                            <div class="asset-thumb" style="display:flex;align-items:center;justify-content:center;color:#52525b;font-size:0.75rem;background:#13131a;">No image</div>
                        @endif
                        <div class="asset-body">
                            <div>
                                <div class="asset-meta">
                                    <span class="asset-badge">Certificate</span>
                                    <span class="asset-date">{{ $cert->created_at->format('M d, Y') }}</span>
                                </div>
                                <h3 class="asset-title">{{ $cert->title }}</h3>
                            </div>
                            <div class="asset-actions">
                                @if($cert->credential_url)
                                    <a href="{{ $cert->credential_url }}" target="_blank" class="btn-action">Verify</a>
                                @endif
                                <a href="{{ route('admin.certificates.edit', $cert) }}" class="btn-action">Edit</a>
                                <form action="{{ route('admin.certificates.destroy', $cert) }}" method="POST" onsubmit="return confirm('Delete this certificate?');" style="flex: 1; display: flex;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" style="width: 100%;">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- MODAL: 3D DESIGN -->
    <div id="modal-3d" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <h3 class="modal-title">Upload 3D Design Asset</h3>
                <button type="button" class="modal-close" onclick="closeModal('modal-3d')">&times;</button>
            </div>
            <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="category" value="3D Design">
                <input type="hidden" name="status" value="Published">
                <div class="form-group">
                    <label class="form-label">Project Title</label>
                    <input type="text" name="title" class="form-input" required placeholder="e.g. Cyberpunk Mech Robot">
                </div>
                <div class="form-group">
                    <label class="form-label">Thumbnail Image (JPG / PNG)</label>
                    <input type="file" name="thumbnail" accept="image/*" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">3D Model File (GLB / GLTF / OBJ)</label>
                    <input type="file" name="model_file" accept=".glb,.gltf,.obj" class="form-input" required>
                    <div class="form-hint">Required for Three.js web preview.</div>
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-textarea" placeholder="Describe your 3D asset..."></textarea>
                </div>
                <button type="submit" class="btn-submit">Upload 3D Asset</button>
            </form>
        </div>
    </div>

    <!-- MODAL: IMAGE / GRAPHIC DESIGN -->
    <div id="modal-image" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <h3 class="modal-title">Upload Graphic Design / Image</h3>
                <button type="button" class="modal-close" onclick="closeModal('modal-image')">&times;</button>
            </div>
            <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="category" value="Graphic Design">
                <input type="hidden" name="status" value="Published">
                <div class="form-group">
                    <label class="form-label">Project Title</label>
                    <input type="text" name="title" class="form-input" required placeholder="e.g. Brand Identity Suite">
                </div>
                <div class="form-group">
                    <label class="form-label">Main Image / Thumbnail (JPG / PNG)</label>
                    <input type="file" name="thumbnail" accept="image/*" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-textarea" placeholder="Project details..."></textarea>
                </div>
                <button type="submit" class="btn-submit">Upload Image Asset</button>
            </form>
        </div>
    </div>

    <!-- MODAL: VIDEO / ANIMATION -->
    <div id="modal-video" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <h3 class="modal-title">Upload Video / Animation</h3>
                <button type="button" class="modal-close" onclick="closeModal('modal-video')">&times;</button>
            </div>
            <form action="{{ url('/admin/projects') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="category" value="Animation">
                <input type="hidden" name="status" value="Published">
                <div class="form-group">
                    <label class="form-label">Project Title</label>
                    <input type="text" name="title" class="form-input" required placeholder="e.g. Motion Reel 2026">
                </div>
                <div class="form-group">
                    <label class="form-label">Thumbnail Image (JPG / PNG)</label>
                    <input type="file" name="thumbnail" accept="image/*" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Video File (MP4)</label>
                    <input type="file" name="video_file" accept="video/mp4" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-textarea" placeholder="Animation details..."></textarea>
                </div>
                <button type="submit" class="btn-submit">Upload Video Asset</button>
            </form>
        </div>
    </div>

    <!-- MODAL: UI/UX FIGMA -->
    <div id="modal-figma" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <h3 class="modal-title">Add UI/UX Figma Project</h3>
                <button type="button" class="modal-close" onclick="closeModal('modal-figma')">&times;</button>
            </div>
            <form action="{{ url('/admin/projects') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="category" value="UI/UX Design">
                <input type="hidden" name="status" value="Published">
                <div class="form-group">
                    <label class="form-label">Project Title</label>
                    <input type="text" name="title" class="form-input" required placeholder="e.g. Fintech Mobile App UI">
                </div>
                <div class="form-group">
                    <label class="form-label">Thumbnail Image (JPG / PNG)</label>
                    <input type="file" name="thumbnail" accept="image/*" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Figma Embed URL</label>
                    <input type="url" name="figma_url" class="form-input" required placeholder="https://www.figma.com/embed?embed_host=share&url=...">
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-textarea" placeholder="UX research and design system info..."></textarea>
                </div>
                <button type="submit" class="btn-submit">Save Figma Project</button>
            </form>
        </div>
    </div>

    <!-- MODAL: CANVA -->
    <div id="modal-canva" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <h3 class="modal-title">Add Canva Project</h3>
                <button type="button" class="modal-close" onclick="closeModal('modal-canva')">&times;</button>
            </div>
            <form action="{{ url('/admin/projects') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="category" value="Canva">
                <input type="hidden" name="status" value="Published">
                <div class="form-group">
                    <label class="form-label">Project Title</label>
                    <input type="text" name="title" class="form-input" required placeholder="e.g. Canva Presentation Design">
                </div>
                <div class="form-group">
                    <label class="form-label">Thumbnail Image (JPG / PNG)</label>
                    <input type="file" name="thumbnail" accept="image/*" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Canva URL</label>
                    <input type="url" name="canva_url" class="form-input" required placeholder="https://www.canva.com/design/...">
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-textarea" placeholder="Canva project details..."></textarea>
                </div>
                <button type="submit" class="btn-submit">Save Canva Project</button>
            </form>
        </div>
    </div>

    <!-- MODAL: MAGAZINE -->
    <div id="modal-magazine" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <h3 class="modal-title">Upload Digital Magazine / PDF</h3>
                <button type="button" class="modal-close" onclick="closeModal('modal-magazine')">&times;</button>
            </div>
            <form action="{{ route('admin.magazines.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">Magazine Title</label>
                    <input type="text" name="title" class="form-input" required placeholder="e.g. Design Quarterly Vol. 01">
                </div>
                <div class="form-group">
                    <label class="form-label">PDF File</label>
                    <input type="file" name="pdf" accept="application/pdf" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Cover Thumbnail</label>
                    <input type="file" name="cover_image" accept=".jpg,.jpeg,.png,image/jpeg,image/png" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-textarea" placeholder="Magazine overview..."></textarea>
                </div>
                <button type="submit" class="btn-submit">Upload Magazine PDF</button>
            </form>
        </div>
    </div>

    <!-- MODAL: CERTIFICATE -->
    <div id="modal-certificate" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <h3 class="modal-title">Add Certificate</h3>
                <button type="button" class="modal-close" onclick="closeModal('modal-certificate')">&times;</button>
            </div>
            <form action="{{ url('/admin/certificates') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">Certificate Title</label>
                    <input type="text" name="title" class="form-input" required placeholder="e.g. Advanced UI/UX Masterclass">
                </div>
                <div class="form-group">
                    <label class="form-label">Issuer</label>
                    <input type="text" name="issuer" class="form-input" required placeholder="e.g. Coursera / Design Academy">
                </div>
                <div class="form-group">
                    <label class="form-label">Date / Year</label>
                    <input type="text" name="date" class="form-input" placeholder="e.g. 2026">
                </div>
                <div class="form-group">
                    <label class="form-label">Certificate File (PDF)</label>
                    <input type="file" name="pdf_file" accept="application/pdf,.pdf" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Image URL / Badge (Optional Thumbnail)</label>
                    <input type="text" name="image" class="form-input" placeholder="https://images.unsplash.com/...">
                </div>
                <div class="form-group">
                    <label class="form-label">Credential Verification URL</label>
                    <input type="url" name="credential_url" class="form-input" placeholder="https://coursera.org/verify/...">
                </div>
                <button type="submit" class="btn-submit">Save Certificate</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.add('active');
        }
        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }
        // Close modal when clicking outside box
        window.onclick = function(event) {
            if (event.target.classList.contains('modal-overlay')) {
                event.target.classList.remove('active');
            }
        }
        // Asset Filter
        function filterAssets(type) {
            // Update active button
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            // Filter cards
            document.querySelectorAll('.asset-card').forEach(card => {
                if (type === 'all' || card.getAttribute('data-type') === type) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
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
                    const targetWidth = parent.clientWidth || 280;
                    const targetHeight = parent.clientHeight || 180;

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
                    console.error('Admin PDF render error:', err);
                }
            });
        });
    </script>
</div>
@endsection
