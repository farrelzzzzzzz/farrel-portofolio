<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Map kategori admin (6 bucket) -> nilai category di tabel projects.
     * Tabel projects sudah berisi: '3D Design', 'Graphic Design',
     * 'Animation', 'UI/UX Design', 'Web Development'.
     */
    public const CATEGORY_MAP = [
        '3d'         => '3D Design',
        'image'      => 'Graphic Design',
        'video'      => 'Animation',
        'figma'      => 'UI/UX Design',
        'web'        => 'Web Development',
        'canva'      => 'Canva',
    ];

    public const CATEGORY_LABELS = [
        '3D Design'       => '3D',
        'Graphic Design'  => 'Image',
        'Animation'       => 'Video',
        'UI/UX Design'    => 'Figma',
        'Web Development' => 'Web',
        'Canva'           => 'Canva',
    ];

    /**
     * Show the admin "edit project" form.
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Create / store a new portfolio asset.
     * Satu endpoint untuk semua 4 kategori Project (3D, Image, Video, Figma).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'              => 'required|string|max:255',
            'category'           => 'required|string|in:3D Design,Graphic Design,Animation,UI/UX Design,Web Development,Canva',
            'short_description'  => 'nullable|string',
            'description'        => 'nullable|string',
            'thumbnail'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'figma_url'          => 'nullable|url',
            'canva_url'          => 'nullable|url',
            'model_file'         => 'nullable|file|max:51200',
            'video_file'         => 'nullable|mimes:mp4,webm|max:102400',
            'pdf_file'           => 'nullable|mimes:pdf|max:20480',
            'status'             => 'required|string|in:Published,Draft',
        ]);

        $data['slug'] = Str::slug($data['title']);

        // Ensure unique slug
        $base = $data['slug'];
        $i = 1;
        while (Project::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $base . '-' . (++$i);
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->publicUrl(
                $request->file('thumbnail')->store('thumbnails', 'public')
            );
        }

        if ($request->hasFile('model_file')) {
            $data['model_file'] = $this->storeModelFile($request->file('model_file'));
        }

        if ($request->hasFile('video_file')) {
            $data['video_file'] = $this->publicUrl(
                $request->file('video_file')->store('videos', 'public')
            );
        }

        if ($request->hasFile('pdf_file')) {
            $data['pdf_file'] = $this->publicUrl(
                $request->file('pdf_file')->store('project-pdfs', 'public')
            );
        }

        $data['gallery'] = $data['thumbnail'] ?? null ? [$data['thumbnail']] : [];

        Project::create($data);

        return back()->with('success', 'Project created successfully with media upload!');
    }

    /**
     * Update an existing project.
     */
    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'title'              => 'required|string|max:255',
            'category'           => 'required|string|in:3D Design,Graphic Design,Animation,UI/UX Design,Web Development,Canva',
            'short_description'  => 'nullable|string',
            'description'        => 'nullable|string',
            'thumbnail'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'figma_url'          => 'nullable|url',
            'canva_url'          => 'nullable|url',
            'model_file'         => 'nullable|file|max:51200',
            'video_file'         => 'nullable|mimes:mp4,webm|max:102400',
            'pdf_file'           => 'nullable|mimes:pdf|max:20480',
            'status'             => 'required|string|in:Published,Draft',
        ]);

        // Re-slug only if title changed
        if ($project->title !== $data['title']) {
            $base = Str::slug($data['title']);
            $slug = $base;
            $i = 1;
            while (Project::where('slug', $slug)->where('id', '!=', $project->id)->exists()) {
                $slug = $base . '-' . (++$i);
            }
            $data['slug'] = $slug;
        }

        if ($request->hasFile('thumbnail')) {
            $this->deleteIfLocal($project->thumbnail);
            $data['thumbnail'] = $this->publicUrl(
                $request->file('thumbnail')->store('thumbnails', 'public')
            );
        }

        if ($request->hasFile('model_file')) {
            $this->deleteIfLocal($project->model_file);
            $data['model_file'] = $this->storeModelFile($request->file('model_file'));
        }

        if ($request->hasFile('video_file')) {
            $this->deleteIfLocal($project->video_file);
            $data['video_file'] = $this->publicUrl(
                $request->file('video_file')->store('videos', 'public')
            );
        }

        if ($request->hasFile('pdf_file')) {
            $this->deleteIfLocal($project->pdf_file);
            $data['pdf_file'] = $this->publicUrl(
                $request->file('pdf_file')->store('project-pdfs', 'public')
            );
        }

        $project->update($data);

        return back()->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        $this->deleteIfLocal($project->thumbnail);
        $this->deleteIfLocal($project->model_file);
        $this->deleteIfLocal($project->video_file);
        $this->deleteIfLocal($project->pdf_file);

        $project->delete();
        return back()->with('success', 'Project deleted successfully!');
    }

    /**
     * Convert a stored relative path to a public URL.
     */
    protected function publicUrl(?string $relativePath): ?string
    {
        if (!$relativePath) return null;
        // If already a full URL, leave it alone (legacy data).
        if (preg_match('#^https?://#i', $relativePath)) return $relativePath;
        return asset('storage/' . ltrim($relativePath, '/'));
    }

    /**
     * Delete a previously stored file IF it lives on our public disk
     * (i.e. path is relative, not a remote http(s) URL).
     */
    protected function deleteIfLocal(?string $urlOrPath): void
    {
        if (!$urlOrPath) return;
        if (preg_match('#^https?://#i', $urlOrPath)) return;

        // Convert URL back to relative path
        $relative = ltrim($urlOrPath, '/');
        $marker = 'storage/';
        if (str_contains($relative, $marker)) {
            $relative = substr($relative, strpos($relative, $marker) + strlen($marker));
        }

        if (Storage::disk('public')->exists($relative)) {
            Storage::disk('public')->delete($relative);
        }
    }

    /**
     * Store a 3D model file. If it's a .blend and Blender CLI is available,
     * export to GLB. Otherwise store as-is.
     */
    protected function storeModelFile($file): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $filename  = time() . '_' . $file->getClientOriginalName();
        $path      = $file->storeAs('models3d', $filename, 'public');
        $absPath   = storage_path('app/public/' . $path);
        $publicUrl = asset('storage/' . $path);

        if ($extension === 'blend') {
            $blenderPath = 'C:\\Program Files\\Blender Foundation\\Blender 3.6\\blender.exe';
            if (file_exists($blenderPath)) {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $glbName      = time() . '_' . $originalName . '.glb';
                $glbPath      = storage_path('app/public/models3d/' . $glbName);
                $cmd = '"' . $blenderPath . '" --background "' . $absPath . '" --python-expr "import bpy; bpy.ops.export_scene.gltf(filepath=\'' . str_replace('\\', '/', $glbPath) . '\', export_format=\'GLB\')" 2>&1';
                exec($cmd, $out, $rc);
                if ($rc === 0 && file_exists($glbPath)) {
                    $publicUrl = asset('storage/models3d/' . $glbName);
                }
            }
        }

        return $publicUrl;
    }
}
