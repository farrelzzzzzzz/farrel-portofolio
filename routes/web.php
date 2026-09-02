<?php

use App\Models\Project;
use App\Models\Certificate;
use App\Models\Magazine;
use App\Http\Controllers\MagazineController;
use Illuminate\Http\Request;

Route::get('/', function (Request $request) {
    $category = $request->query('category', 'All');
    
    if ($category === 'All' || !$category) {
        $projects = Project::where('status', 'Published')->latest()->get();
    } else {
        $projects = Project::where('status', 'Published')->latest()->get();
    }

    $certificates = Certificate::all();

    $allProjectsCount = Project::where('status', 'Published')->count();
    $uiuxCount = Project::where('status', 'Published')->where('category', 'UI/UX Design')->count();
    $graphicCount = Project::where('status', 'Published')->where('category', 'Graphic Design')->count();
    $tdCount = Project::where('status', 'Published')->where('category', '3D Design')->count();
    $animationCount = Project::where('status', 'Published')->where('category', 'Animation')->count();
    $webCount = Project::where('status', 'Published')->where('category', 'Web Development')->count();

    return view('portfolio', compact(
        'projects', 'category', 'allProjectsCount', 'uiuxCount', 'graphicCount', 'tdCount', 'animationCount', 'webCount'
    ));
});

Route::get('/certificates', function () {
    $certificates = Certificate::latest()->get();
    return view('certificates', compact('certificates'));
})->name('certificates');

Route::get('/project/{slug}', function ($slug) {
    $project = Project::where('slug', $slug)->firstOrFail();
    $project->increment('views');
    return view('project-detail', compact('project'));
});

// Simple Admin Panel Routes
Route::get('/admin/login', function () {
    return view('admin.login');
})->name('login');

Route::post('/admin/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (auth()->attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/admin/dashboard');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', function () {
        $totalProjects = Project::count();
        $totalViews = Project::sum('views');
        $projects = Project::latest()->get();
        $certificates = Certificate::latest()->get();
        $magazines = Magazine::latest()->get();
        return view('admin.dashboard', compact('totalProjects', 'totalViews', 'projects', 'certificates', 'magazines'));
    })->name('admin.dashboard');

    Route::post('/admin/projects', function (Request $request) {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'figma_url' => 'nullable|url',
            'model_file' => 'nullable|file|max:51200',
            'video_file' => 'nullable|mimes:mp4|max:102400',
            'pdf_file' => 'nullable|mimes:pdf|max:20480',
            'status' => 'required|string'
        ]);
        
        $data['slug'] = \Illuminate\Support\Str::slug($data['title']);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $data['thumbnail'] = asset('storage/' . $path);
        }

        if ($request->hasFile('model_file')) {
            $file = $request->file('model_file');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = strtolower($file->getClientOriginalExtension());
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('models3d', $filename, 'public');
            $fileFullPath = storage_path('app/public/' . $path);
            
            $publicUrl = asset('storage/' . $path);

            // Check if Blender CLI is available at standard Windows path
            $blenderPath = 'C:\\Program Files\\Blender Foundation\\Blender 3.6\\blender.exe';
            if ($extension === 'blend' && file_exists($blenderPath)) {
                $outputGlbName = time() . '_' . $originalName . '.glb';
                $outputGlbPath = storage_path('app/public/models3d/' . $outputGlbName);
                
                // Blender headless python export script
                $cmd = '"' . $blenderPath . '" --background "' . $fileFullPath . '" --python-expr "import bpy; bpy.ops.export_scene.gltf(filepath=\'' . str_replace('\\', '/', $outputGlbPath) . '\', export_format=\'GLB\')" 2>&1';
                exec($cmd, $output, $returnVar);

                if ($returnVar === 0 && file_exists($outputGlbPath)) {
                    $publicUrl = asset('storage/models3d/' . $outputGlbName);
                }
            }

            $data['model_file'] = $publicUrl;
        }

        if ($request->hasFile('video_file')) {
            $path = $request->file('video_file')->store('videos', 'public');
            $data['video_file'] = asset('storage/' . $path);
        }

        if ($request->hasFile('pdf_file')) {
            $path = $request->file('pdf_file')->store('magazines', 'public');
            $data['pdf_file'] = asset('storage/' . $path);
        }

        $data['gallery'] = [$data['thumbnail'] ?? 'https://images.unsplash.com/photo-1563986768609-322da13575f3'];
        
        Project::create($data);
        return back()->with('success', 'Project created successfully with media upload!');
    });

    Route::post('/admin/certificates', function (Request $request) {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'date' => 'nullable|string|max:50',
            'image' => 'nullable|string',
            'credential_url' => 'nullable|url',
        ]);

        Certificate::create($data);
        return back()->with('success', 'Certificate added successfully!');
    });

    Route::delete('/admin/projects/{project}', function (Project $project) {
        $project->delete();
        return back()->with('success', 'Project deleted successfully!');
    });

    Route::get('/admin/magazines', [MagazineController::class, 'index'])->name('admin.magazines.index');
    Route::get('/admin/magazines/create', [MagazineController::class, 'create'])->name('admin.magazines.create');
    Route::post('/admin/magazines', [MagazineController::class, 'store'])->name('admin.magazines.store');
    Route::get('/admin/magazines/{magazine}/edit', [MagazineController::class, 'edit'])->name('admin.magazines.edit');
    Route::put('/admin/magazines/{magazine}', [MagazineController::class, 'update'])->name('admin.magazines.update');
    Route::delete('/admin/magazines/{magazine}', [MagazineController::class, 'destroy'])->name('admin.magazines.destroy');

    Route::post('/admin/logout', function (Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('admin.logout');
});
