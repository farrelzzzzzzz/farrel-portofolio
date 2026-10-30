<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Center — Farrel Balapradhana</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #050507;
            color: #d4d4d8;
            font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
            margin: 0;
            padding: 0;
        }
        .admin-nav {
            background-color: #050507;
            border-bottom: 1px solid #202027;
            padding: 1.25rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(12px);
            background-color: rgba(5, 5, 7, 0.85);
        }
        .admin-logo {
            font-size: 1.1rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            color: #ffffff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }
        .admin-logo-dot {
            color: #e50914;
            text-shadow: 0 0 10px rgba(229, 9, 20, 0.6);
        }
        .admin-logo-sub {
            font-size: 0.7rem;
            color: #8b8b94;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-left: 0.5rem;
            border-left: 1px solid #28282f;
            padding-left: 0.75rem;
        }
        .admin-nav-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .admin-nav-link {
            font-size: 0.85rem;
            color: #d4d4d8;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }
        .admin-nav-link:hover {
            color: #ffffff;
        }
        .admin-logout-btn {
            background: rgba(229, 9, 20, 0.1);
            border: 1px solid rgba(229, 9, 20, 0.3);
            color: #e50914;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .admin-logout-btn:hover {
            background-color: #e50914;
            color: #ffffff;
            border-color: #e50914;
        }

        /* Responsive Improvements for Mobile & Tablet */
        @media (max-width: 1024px) {
            .admin-nav {
                padding: 1rem;
                flex-wrap: wrap;
                gap: 1rem;
            }
            .admin-nav-actions {
                width: 100%;
                justify-content: space-between;
                overflow-x: auto;
                padding-bottom: 0.5rem;
                gap: 1rem;
            }
            .admin-nav-link {
                white-space: nowrap;
                font-size: 0.8rem;
            }
        }
        @media (max-width: 640px) {
            .admin-nav-actions {
                justify-content: flex-start;
                gap: 1.25rem;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="relative overflow-x-hidden">
    <!-- Ambient Background Animation & Tiny Stars -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-40 -left-40 w-96 h-96 rounded-full bg-indigo-900/15 blur-3xl animate-pulse" style="animation-duration: 7s;"></div>
        <div class="absolute top-1/2 -right-40 w-96 h-96 rounded-full bg-rose-900/15 blur-3xl animate-pulse" style="animation-duration: 10s;"></div>
        <!-- Tiny CSS Stars -->
        <div class="absolute top-[20%] left-[30%] w-1 h-1 bg-white/40 rounded-full animate-ping" style="animation-duration: 4s;"></div>
        <div class="absolute top-[60%] left-[70%] w-1.5 h-1.5 bg-blue-300/30 rounded-full animate-pulse" style="animation-duration: 5s;"></div>
        <div class="absolute top-[80%] left-[25%] w-1 h-1 bg-white/30 rounded-full animate-ping" style="animation-duration: 6s;"></div>
    </div>

    <!-- Top Navigation -->
    <nav class="admin-nav" style="background: linear-gradient(135deg, rgba(11,11,15,0.95) 0%, rgba(18,18,26,0.95) 100%); border-bottom: 1px solid rgba(255,255,255,0.08); backdrop-filter: blur(16px);">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <a href="/admin/dashboard" class="admin-logo">
                <div style="width: 32px; height: 32px; border-radius: 10px; background: linear-gradient(135deg, #e50914, #ff4d4d); display: flex; align-items: center; justify-content: center; color: white; box-shadow: 0 4px 12px rgba(229,9,20,0.4);">
                    <i class="fa-solid fa-gauge-high" style="font-size: 0.85rem;"></i>
                </div>
                <span>FARREL<span class="admin-logo-dot">.</span></span>
                <span class="admin-logo-sub" style="background: rgba(255,255,255,0.05); padding: 2px 8px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.1);">Control Center</span>
            </a>
        </div>
        <div class="admin-nav-actions" style="gap: 0.75rem;">
            <a href="/" target="_blank" class="admin-nav-link" style="background: rgba(59, 130, 246, 0.15); border: 1px solid rgba(59, 130, 246, 0.3); padding: 0.45rem 0.85rem; border-radius: 10px; color: #60a5fa; font-weight: 600; display: inline-flex; align-items: center; gap: 0.4rem; transition: all 0.2s;">
                <i class="fa-solid fa-globe"></i> Lihat Web <i class="fa-solid fa-arrow-up-right-from-square" style="font-size: 0.65rem; opacity: 0.7;"></i>
            </a>
            <a href="{{ route('admin.smtp.setup') }}" class="admin-nav-link" style="background: rgba(245, 158, 11, 0.12); border: 1px solid rgba(245, 158, 11, 0.3); padding: 0.45rem 0.85rem; border-radius: 10px; color: #fbbf24; font-weight: 600; display: inline-flex; align-items: center; gap: 0.4rem; transition: all 0.2s;">
                <i class="fa-solid fa-envelope-circle-check"></i> SMTP
            </a>
            <a href="{{ route('admin.settings') }}" class="admin-nav-link" style="background: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.3); padding: 0.45rem 0.85rem; border-radius: 10px; color: #34d399; font-weight: 600; display: inline-flex; align-items: center; gap: 0.4rem; transition: all 0.2s;">
                <i class="fa-solid fa-gear"></i> Settings
            </a>
            <a href="{{ route('admin.magazines.index') }}" class="admin-nav-link" style="background: rgba(99, 102, 241, 0.12); border: 1px solid rgba(99, 102, 241, 0.3); padding: 0.45rem 0.85rem; border-radius: 10px; color: #818cf8; font-weight: 600; display: inline-flex; align-items: center; gap: 0.4rem; transition: all 0.2s;">
                <i class="fa-solid fa-book-open"></i> Magazines
            </a>
            <form action="/admin/logout" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="admin-logout-btn" style="background: rgba(229, 9, 20, 0.15); border: 1px solid rgba(229, 9, 20, 0.4); color: #f87171; padding: 0.45rem 1rem; border-radius: 10px; font-weight: 600; display: inline-flex; align-items: center; gap: 0.4rem;">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

</body>
</html>
