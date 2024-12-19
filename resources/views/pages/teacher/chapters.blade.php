@extends('layouts.app')

@section('title')
    Chapters for {{ $unit->title }}
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

    <div class="p-3 text-[#667085] my-8">
        <i class="fa-solid fa-house mx-2"></i>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="{{ route('teacher.dashboard') }}" class="mx-2 cursor-pointer">Dashboard</a>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="#" class="mx-2 cursor-pointer">Chapters</a>
    </div>

    <!-- Display Chapters -->
    <div class="flex flex-wrap">
        @foreach ($unit->chapters as $chapter)
            <div class="w-full sm:w-1/2 lg:w-1/4 p-3">
                <!-- Make the card a clickable link -->
                <a href="{{ route('teacher.lessons.index', $chapter->id) }}" class="block">
                    <div class="h-[350px] bg-white  border border-slate-200 rounded-md">
                        <h3 class="px-4 py-2 bg-gray-200 text-lg font-bold">{{ $chapter->title }}</h3>

                        <!-- Chapter Image -->
                        <div class="p-4">
                            <img src="{{ $chapter->image ? asset('storage/' . $chapter->image) : asset('images/defaultCard.webp')  }}"
                                alt="{{ $chapter->title }}" class="object-cover w-full h-32 rounded-md">
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection