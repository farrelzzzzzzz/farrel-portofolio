@extends('admin.layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">Admin Dashboard</h1>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <!-- Magazine Management Section -->
        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Manage Magazines (Flipbook)</h2>
            
            <form action="{{ route('admin.magazines.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 mb-8 bg-gray-50 p-4 rounded-md border">
                @csrf
                <h3 class="text-md font-semibold text-gray-700">Upload New Magazine PDF</h3>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm border p-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm border p-2"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">PDF File</label>
                    <input type="file" name="pdf" accept="application/pdf" required class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm">Upload Magazine</button>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $magazines = \App\Models\Magazine::latest()->get();
                        @endphp
                        @forelse($magazines as $magazine)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $magazine->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ Str::limit($magazine->description, 50) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <a href="{{ asset('storage/' . $magazine->pdf_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">View PDF</a>
                                    <form action="{{ route('admin.magazines.destroy', $magazine->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this magazine?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">No magazines uploaded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
