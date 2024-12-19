@php
    $userAuth = auth()->guard('teacher')->user();
@endphp

@extends('layouts.app')

@section('title')
    Resources
@endsection

@php
    $menuItems = [
        ['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.dashboard')],
        ['label' => 'Resources', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.resources.index')],
    ];
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
                <span class="mx-2 cursor-pointer">Resources</span>
            </div>
            <a href="{{ route('teacher.resources.create') }}"
                class="text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">
                Add New Resource
            </a>
        </div>
        @if (session('success'))
            <div class="bg-green-500 text-white p-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="p-3">
            <form method="GET" action="{{ route('teacher.resources.index') }}" class="mb-4">
                <label for="grade" class="block text-sm font-medium text-gray-700">Filter by Grade</label>
                <select id="grade" name="grade" class="w-full p-2 border border-gray-300 rounded">
                    <option value="">All Grades</option>
                    @foreach ($stages as $stage)
                        <option value="{{ $stage->id }}" {{ request('grade') == $stage->id ? 'selected' : '' }}>
                            {{ $stage->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit"
                    class="mt-2 text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg">Filter</button>
            </form>
            <div class="overflow-x-auto rounded-2xl border border-[#EAECF0]">
                <div class="container mx-auto px-4 py-8">
                    <h1 class="text-2xl font-bold mb-4">My Resources</h1>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($resources as $resource)
                            <div class="border rounded-lg p-4">
                                <a href="{{ asset($resource->file_path) }}" target="_blank" class="block">
                                    <img src="{{ $resource->image ? asset($resource->image) : asset('assets/img/default.png') }}"
                                        alt="{{ $resource->name }}" class="object-cover w-full h-48 rounded-md mb-4">
                                    <h3 class="text-lg font-bold">{{ $resource->name }}</h3>
                                    <p class="text-gray-500 mb-3">{{ $resource->description }}</p>
                                    <b class="mt-3">
                                        {{ $resource->stage->name }}
                                    </b>
                                </a>
                                <div class="flex justify-between mt-4">
                                    <a href="{{ route('teacher.resources.edit', $resource->id) }}"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Edit</a>
                                    <form action="{{ route('teacher.resources.destroy', $resource->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this resource?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($resources->isEmpty())
                        <p class="text-gray-500 text-center mt-6">No resources available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
