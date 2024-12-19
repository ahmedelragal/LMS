@extends('layouts.app')

@section('title')
    Lessons for {{ $chapter->title }}
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

    <div class="p-3 text-[#667085] my-8">
        <i class="fa-solid fa-house mx-2"></i>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="{{ route('teacher.dashboard') }}" class="mx-2 cursor-pointer">Grade</a>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="{{ route('teacher.units', $chapter->material_id) }}" class="mx-2 cursor-pointer">Units</a>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="#" class="mx-2 cursor-pointer">Lessons</a>
    </div>

    <!-- Display Lessons -->
    <div class="flex flex-wrap">
        @foreach ($chapter->lessons as $lesson)
            <div class="w-full sm:w-1/2 lg:w-1/4 p-3">
                <div class=" bg-white ">

                    <div class="p-4">

                        <button onclick="event.stopPropagation(); event.preventDefault(); openModal('ebook', '{{ $lesson->file_path }}');" class="object-cover w-full">
                            <img src="{{ $lesson->image ? asset($lesson->image) : asset('images/defaultCard.webp') }}" alt="{{ $lesson->title }}">
                        </button>
                    </div>
                    <h3 class="px-4 py-2 text-lg font-bold truncate">{{ $lesson->title }}</h3>
                </div>
            </div>
        @endforeach
        @if(count($chapter->lessons) == 0)
            <p class="m-auto text-gray-500">No Lessons yet</p>
        @endif
    </div>
@endsection



{{-- ------------------------------------------------------------------------------------- --}}

{{-- Ebook Modal --}}
<div id="ebook" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-10 hidden">
    <div class="bg-white rounded-lg shadow-lg h-[95vh] overflow-y-scroll w-[90%]">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">
                EBook
            </h3>
            <div class="flex justify-end">
                <button onclick="closeModal('ebook')"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close</button>
            </div>
        </div>

        <div id="ebook-content" class="relative">
        </div>
    </div>
</div>

@section('page_js')
<script>
    function openModal(lessonId, filePath) {
        let modalContent = `
            <embed src="${filePath}" width="100%" height="90%" />
            <img src="{{ asset('assets/img/watermark 2.png') }}" 
                class="absolute inset-0 w-full h-full opacity-50 z-10"
                style="pointer-events: none;">
        `;
        document.getElementById('ebook-content').innerHTML = modalContent;

        document.getElementById('ebook').classList.remove("hidden");
    }

    function closeModal(id) {
        document.getElementById(id).classList.add("hidden");
    }
</script>
@endsection
