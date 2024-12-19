@extends('layouts.app')

@section('title')
    Materials for {{ $stage->name }}
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
        <a href="{{ route('teacher.dashboard') }}" class="mx-2 cursor-pointer">Grade</a>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="" class="mx-2 cursor-pointer">Materials</a>
    </div>

    <!-- Display Materials -->
    <div class="flex flex-wrap">
        @foreach ($stage->materials as $material)
            <div class="w-full sm:w-1/2 lg:w-1/4 p-3">
                <!-- Wrap the material card in a link to navigate to units -->
                <a href="{{ route('teacher.units', $material->id) }}" class="block">
                    <div class="h-[350px] bg-white shadow-md border border-slate-200 rounded-md">
                        <h3 class="px-4 py-2 bg-gray-200 text-lg font-bold">{{ $material->title }}</h3>

                        <!-- Material Image -->
                        <div class="p-4">
                            <img src="{{ $material->image ? asset($material->image) :asset('images/defaultCard.webp')}}"
                                alt="{{ $material->title }}" class="object-cover w-full h-32 rounded-md">
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection


