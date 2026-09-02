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
            'pdf' => 'required|mimes:pdf|max:30720',
        ]);

        $pdfPath = $request->file('pdf')->store('magazines', 'public');

        Magazine::create([
            'title' => $request->title,
            'description' => $request->description,
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
            'pdf' => 'nullable|mimes:pdf|max:30720',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];

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

        $magazine->delete();

        return redirect()->route('admin.magazines.index')->with('success', 'Magazine deleted successfully.');
    }
}
