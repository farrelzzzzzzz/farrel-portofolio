@extends('admin.layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold text-gray-900">Edit Magazine</h1>

        <form action="{{ route('admin.magazines.update', $magazine->id) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6 bg-white p-6 shadow sm:rounded-md">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" value="{{ $magazine->title }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm border p-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm border p-2">{{ $magazine->description }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Current PDF</label>
                <a href="{{ asset('storage/' . $magazine->pdf_path) }}" target="_blank" class="text-indigo-600 underline text-sm">View Current PDF</a>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Replace PDF (Optional)</label>
                <input type="file" name="pdf" accept="application/pdf" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>

            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Update</button>
        </form>
    </div>
</div>
@endsection
