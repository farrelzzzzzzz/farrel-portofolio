<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function edit(Certificate $certificate)
    {
        return view('admin.certificates.edit', compact('certificate'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'issuer'         => 'required|string|max:255',
            'date'           => 'nullable|string|max:50',
            'image'          => 'nullable',
            'pdf_file'       => 'nullable|mimes:pdf|max:20480',
            'credential_url' => 'nullable|url',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('certificates', 'public');
            $data['image'] = asset('storage/' . $path);
        }

        if ($request->hasFile('pdf_file')) {
            $data['pdf_file'] = $request->file('pdf_file')->store('certificates', 'public');
        }

        Certificate::create($data);
        return back()->with('success', 'Certificate added successfully!');
    }

    public function update(Request $request, Certificate $certificate)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'issuer'         => 'required|string|max:255',
            'date'           => 'nullable|string|max:50',
            'image'          => 'nullable',
            'pdf_file'       => 'nullable|mimes:pdf|max:20480',
            'credential_url' => 'nullable|url',
        ]);

        if ($request->hasFile('image')) {
            if ($certificate->image && !preg_match('#^https?://#i', $certificate->image)) {
                $old = ltrim($certificate->image, '/');
                if (str_contains($old, 'storage/')) {
                    $old = substr($old, strpos($old, 'storage/') + strlen('storage/'));
                }
                if (Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
            }
            $path = $request->file('image')->store('certificates', 'public');
            $data['image'] = asset('storage/' . $path);
        }

        if ($request->hasFile('pdf_file')) {
            if ($certificate->pdf_file && Storage::disk('public')->exists($certificate->pdf_file)) {
                Storage::disk('public')->delete($certificate->pdf_file);
            }
            $data['pdf_file'] = $request->file('pdf_file')->store('certificates', 'public');
        }

        $certificate->update($data);
        return back()->with('success', 'Certificate updated successfully!');
    }

    public function destroy(Certificate $certificate)
    {
        if ($certificate->image && !preg_match('#^https?://#i', $certificate->image)) {
            $old = ltrim($certificate->image, '/');
            if (str_contains($old, 'storage/')) {
                $old = substr($old, strpos($old, 'storage/') + strlen('storage/'));
            }
            if (Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
        }
        if ($certificate->pdf_file && Storage::disk('public')->exists($certificate->pdf_file)) {
            Storage::disk('public')->delete($certificate->pdf_file);
        }
        $certificate->delete();
        return back()->with('success', 'Certificate deleted successfully!');
    }
}
