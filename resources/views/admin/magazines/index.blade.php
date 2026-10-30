@extends('admin.layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h1 class="text-2xl font-semibold text-gray-900">Magazines Management</h1>
            <a href="{{ route('admin.magazines.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm">Upload New Magazine</a>
        </div>

        @if(session('success'))
            <div class="mt-4 p-4 bg-green-100 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @forelse($magazines as $magazine)
                    <li class="px-4 sm:px-6 py-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                        <div class="pr-0 sm:pr-4">
                            <h3 class="text-lg font-medium text-gray-900">{{ $magazine->title }}</h3>
                            <p class="text-sm text-gray-500">{{ Str::limit($magazine->description, 100) }}</p>
                        </div>
                        <div class="flex space-x-2 self-end sm:self-center shrink-0">
                            <a href="{{ route('admin.magazines.edit', $magazine->id) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">Edit</a>
                            <form action="{{ route('admin.magazines.destroy', $magazine->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">Delete</button>
                            </form>
                        </div>
                    </li>
                @empty
                    <li class="px-6 py-4 text-center text-gray-500">No magazines uploaded yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
