@php
    $userAuth = auth()->guard('teacher')->user();
@endphp

@extends('layouts.app')

@section('title')
    Resources
@endsection

@php
    $menuItems = [['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.dashboard')],
    ['label' => 'Resources', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.resources.index')],];
@endphp
@section('sidebar')
    @include('components.sidebar', ['menuItems' => $menuItems])
@endsection

@section('content')
    @include('components.profile')

    <div class="p-3">
        <div class="flex justify-between items-center px-5 my-8">
            <div class="text-[#667085]">
                <i class="fa-solid fa-house mx-2"></i>
                <span class="mx-2 text-[#D0D5DD]">/</span>
                <a href="#" class="mx-2 cursor-pointer">Resources</a>
            </div>

        </div>

        <div class="p-3">
            <div class="overflow-x-auto rounded-2xl border border-[#EAECF0]">
                <div class="container mx-auto px-4 py-8">

                    <div class="flex justify-between items-center px-5 ">
                        <h1 class="text-2xl font-bold">Edit Resource</h1>
                    </div>

                    <div class="p-3">
                        <form action="{{ route('teacher.resources.update', $resource->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-4">
                                <label for="name" class="block font-medium mb-4"> Name</label>
                                <input type="text" id="name" name="name"
                                    value="{{ old('name', $resource->name) }}" required
                                    class="w-full p-2 border border-gray-300 rounded">
                                @error('name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="description" class="block font-medium mb-4">Description</label>
                                <textarea id="description" name="description" rows="3" class="w-full p-2 border border-gray-300 rounded">{{ old('description', $resource->description) }}</textarea>
                                @error('description')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="stage_id" class="block font-medium mb-4">Stage</label>
                                <select id="stage_id" name="stage_id" required
                                    class="w-full p-2 border border-gray-300 rounded">
                                    @foreach ($stages as $stage)
                                        <option value="{{ $stage->id }}"
                                            {{ $stage->id == $resource->stage_id ? 'selected' : '' }}>
                                            {{ $stage->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('stage_id')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="image" class="block font-medium mb-4">Image
                                    (optional)</label>
                                <input type="file" id="image" name="image" accept="image/*"
                                    class="w-full p-2 border border-gray-300 rounded">
                                @error('image')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label for="file_path" class="block font-medium mb-4">Resource File
                                    (PDF)</label>
                                <input type="file" id="file_path" name="file_path" accept="application/pdf" 
                                    class="w-full p-2 border border-gray-300 rounded">
                                <p class="text-gray-500 text-sm mt-1">Current file: <a
                                        href="{{ asset($resource->file_path) }}"
                                        target="_blank">{{ basename($resource->file_path) }}</a></p>
                                @error('file_path')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- <div class="form-group mb-4">
                                <label for="type" class="block font-medium mb-4">Type</label>
                                <select id="type" name="type" required
                                    class="w-full p-2 border border-gray-300 rounded border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    <option value="pdf" {{ $resource->type == 'pdf' ? 'selected' : '' }}>PDF</option>
                                    <option value="ebook" {{ $resource->type == 'ebook' ? 'selected' : '' }}>Ebook
                                    </option>
                                </select>
                                @error('type')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div> --}}

                            <div class="flex justify-end">
                                <button type="submit"
                                    class="bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-lg">
                                    Update Resource
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
