@extends('layouts.app')

@section('title')
Teacher Dashboard
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
    <a href="" class="mx-2 cursor-pointer">Grade</a>
</div>

<!-- Display Stages -->
<div class="flex flex-wrap">
    @foreach ($stages as $stage)
    <div class="w-full sm:w-1/2 lg:w-1/4 p-3">
        <div class=" bg-white ">
            <!-- Make the stage card a link -->
            <a href="{{ route('teacher.info', $stage->id) }}" class="block h-full">

                <!-- Stage Image -->
                <div class="p-4">

                    <img src="{{ $stage->image ? asset($stage->image) : asset('images/defaultCard.webp') }}"
                        alt="{{ $stage->name }}" class="object-cover w-full h-45 rounded-md">

                </div>
                <h3 class="px-4 py-2 text-lg font-bold">{{ $stage->name }}</h3>
            </a>
        </div>
    </div>
    @endforeach
</div>
@endsection