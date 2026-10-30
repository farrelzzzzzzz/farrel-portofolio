<?php

namespace App\Http\Controllers;

use App\Models\Magazine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MagazineController extends Controller
{
    public function portfolioIndex()
    {
        $magazines = Magazine::latest()->get();
        return view('portfolio.magazines.index', compact('magazines'));
    }

    public function index()
    {
        $magazines = Magazine::latest()->get();
        return view('admin.magazines.index', compact('magazines'));
    }

    public function create()
    {
        return view('admin.magazines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'pdf' => 'required|mimes:pdf|max:30720',
        ]);

        $pdfPath = $request->file('pdf')->store('magazines', 'public');
        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('magazines/covers', 'public');
        }

        Magazine::create([
            'title' => $request->title,
            'description' => $request->description,
            'cover_image_path' => $coverPath,
            'pdf_path' => $pdfPath,
        ]);

        return redirect()->route('admin.magazines.index')->with('success', 'Magazine uploaded successfully.');
    }

    public function edit(Magazine $magazine)
    {
        return view('admin.magazines.edit', compact('magazine'));
    }

    public function update(Request $request, Magazine $magazine)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'pdf' => 'nullable|mimes:pdf|max:30720',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        if ($request->hasFile('cover_image')) {
            if ($magazine->cover_image_path && Storage::disk('public')->exists($magazine->cover_image_path)) {
                Storage::disk('public')->delete($magazine->cover_image_path);
            }
            $data['cover_image_path'] = $request->file('cover_image')->store('magazines/covers', 'public');
        }

        if ($request->hasFile('pdf')) {
            if ($magazine->pdf_path && Storage::disk('public')->exists($magazine->pdf_path)) {
                Storage::disk('public')->delete($magazine->pdf_path);
            }
            $data['pdf_path'] = $request->file('pdf')->store('magazines', 'public');
        }

        $magazine->update($data);

        return redirect()->route('admin.magazines.index')->with('success', 'Magazine updated successfully.');
    }

    public function destroy(Magazine $magazine)
    {
        if ($magazine->pdf_path && Storage::disk('public')->exists($magazine->pdf_path)) {
            Storage::disk('public')->delete($magazine->pdf_path);
        }

        if ($magazine->cover_image_path && Storage::disk('public')->exists($magazine->cover_image_path)) {
            Storage::disk('public')->delete($magazine->cover_image_path);
        }

        $magazine->delete();

        return redirect()->route('admin.magazines.index')->with('success', 'Magazine deleted successfully.');
    }

    public function show(Magazine $magazine)
    {
        return view('portfolio.magazines.show', compact('magazine'));
    }

    /**
     * Stream the magazine PDF with proper HTTP Range support.
     * PHP's built-in dev server does not handle Range requests for static
     * files (it returns 200 + 0 bytes), which makes pdf.js throw "204".
     * Routing through PHP with BinaryFileResponse fixes that.
     */
    public function stream(Request $request, Magazine $magazine)
    {
        $disk = Storage::disk('public');

        if (! $magazine->pdf_path || ! $disk->exists($magazine->pdf_path)) {
            abort(404, 'Magazine PDF not found.');
        }

        $absolutePath = $disk->path($magazine->pdf_path);

        return response()->file($absolutePath, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.basename($absolutePath).'"',
            'Accept-Ranges'       => 'bytes',
            'Cache-Control'       => 'public, max-age=3600',
        ]);
    }
}
