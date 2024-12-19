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
        <a href="{{ route('teacher.dashboard') }}" class="mx-2 cursor-pointer">Grade</a>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="" class="mx-2 cursor-pointer">Info</a>
    </div>

    <!-- Display Stages -->
    <div class="flex flex-wrap p-3">
        <div class="w-full sm:w-1/2 lg:w-1/4 p-2">
            <div class=" bg-white  ">
                <!-- Make the stage card a link -->
                <a href="{{ route('teacher.showMaterials', $id) }}" class="block h-full">

                    <!-- Stage Image -->
                    <div class="p-4">
                        <img src="{{ asset('assets/img/teacherInfo1.png') }}" alt=""
                            class="object-cover w-full h-45 rounded-md">
                    </div>

                    <h3 class="px-4 py-2 text-lg font-bold">Materials</h3>
                </a>
            </div>
        </div>
        <div class="w-full sm:w-1/2 lg:w-1/4 p-2">
            <div class=" bg-white  ">
                <!-- Make the stage card a link -->
                <a href="{{ route('assignments.index') }}" class="block h-full">

                    <!-- Stage Image -->
                    <div class="p-4">
                        <img src="{{ asset('assets/img/teacherInfo2.png') }}" alt=""
                            class="object-cover w-full h-45 rounded-md">
                    </div>
                    <h3 class="px-4 py-2 text-lg font-bold">Assignments</h3>
                </a>
            </div>
        </div>
        <div class="w-full sm:w-1/2 lg:w-1/4 p-2">
            <div class=" bg-white  ">

                <a href="{{ route('teacher_classes', $id) }}" class="block h-full">
                    <div class="p-4">
                        <img src="{{ asset('assets/img/teacherInfo3.png') }}" alt=""
                            class="object-cover w-full h-45 rounded-md">
                    </div>
                    <h3 class="px-4 py-2 text-lg font-bold">Assessments</h3>
                </a>
            </div>
        </div>
        {{-- <div class="w-full sm:w-1/2 lg:w-1/4 p-2">
            <div class=" bg-white  ">

                <a href="{{ route('teacher.resources.index', $id) }}" class="block h-full">
                    <div class="p-4">
                        <img src="{{ asset('assets/img/teacherInfo3.png') }}" alt=""
                            class="object-cover w-full h-45 rounded-md">
                    </div>
                    <h3 class="px-4 py-2 text-lg font-bold">Resources</h3>
                </a>
            </div>
        </div> --}}
    </div>
@endsection
