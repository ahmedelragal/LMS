@extends('layouts.app')

@section('title')
    Theme
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
<div>
    @include('components.profile')

    <div class="p-3 text-[#667085] my-8">
        <i class="fa-solid fa-house mx-2"></i>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="{{ route('teacher.dashboard') }}" class="mx-2 cursor-pointer">Grade</a>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="{{route('teacher.info', $stage->id) }}" class="mx-2 cursor-pointer">Info</a>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="#" class="mx-2 cursor-pointer">Theme</a>

    </div>
    <div class="p-3 flex flex-wrap justify-start">
        @foreach ($stage->materials as $material)
            <div class="mb-7 w-full md:w-[45%] lg:w-[30%] p-2 mx-2 bg-white shadow-md rounded-xl min-h-[380px]">
                <div class="h-full">
                    <a class="cursor-pointer h-full flex flex-col justify-between"
                        href="{{ route('teacher.units' ,$material->id ) }}">
                        <img src="{{ $material->image ? asset($material->image) : asset('images/defaultCard.webp') }}"
                        alt="{{ $material->title }}" class="object-cover object-top w-full h-[350px] rounded-xl">

                        <div class="text-slate-800">
                            <div class="flex justify-between items-center text-2xl">
                                <p class="font-semibold truncate">{{ $material->title }}</p>
                                <button class="pt-2"
                                    onclick="event.stopPropagation(); event.preventDefault(); openModal('ebook', '{{ $material->file_path }}');">
                                    <img src="{{ asset('images/Clip path group.png') }}">
                                </button>
                            </div>
                            <div class="flex justify-between items-center mt-4">
                                <div>
                                    <button class="bg-[#17253E] p-2 text-white rounded-md"
                                        onclick="event.stopPropagation(); event.preventDefault(); openModal('use', '{{ $material->how_to_use }}');">
                                        How To Use
                                        <button>
                                </div>
                                <div>
                                    <button class="bg-white border border-[#FF7519] p-2 text-black font-semibold rounded-md"
                                        onclick="event.stopPropagation(); event.preventDefault(); openModal('learn', '{{ $material->learning}}');">
                                        Learning Outcomes
                                        <button>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
        @if(count($stage->materials) == 0)
            <p class="m-auto text-gray-500">No Themes yet</p>
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

        <div class="relative" id="ebook-content">
        </div>
    </div>
</div>

{{-- How To Use Modal --}}
<div id="use" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden z-10">
    <div class="bg-white rounded-lg shadow-lg h-[95vh] overflow-y-scroll w-[90%]">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">
                How To Use
            </h3>
            <div class="flex justify-end">
                <button onclick="closeModal('use')"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close</button>
            </div>
        </div>

        <div class="relative" id="use-content">
        </div>
    </div>
</div>

{{-- Learning Modal --}}
<div id="learn" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center hidden z-10">
    <div class="bg-white rounded-lg shadow-lg h-[95vh] overflow-y-scroll w-[90%]">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">
                Learning
            </h3>
            <div class="flex justify-end">
                <button onclick="closeModal('learn')"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Close</button>
            </div>
        </div>
        
        <div class="relative" id="learn-content">
        </div>
    </div>
</div>

@section('page_js')
<script>
   function openModal(id, filePath) {
        let modalContent = `
            <embed src="${filePath}" width="100%" height="90%" />
            <img src="{{ asset('assets/img/watermark 2.png') }}" 
                class="absolute inset-0 w-full h-full opacity-50 z-10"
                style="pointer-events: none;">
        `;
        document.getElementById(id + '-content').innerHTML = modalContent;
        document.getElementById(id).classList.remove("hidden");
    }


    function closeModal(id) {
        document.getElementById(id).classList.add("hidden");
    }
</script>
@endsection
