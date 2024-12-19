@extends('layouts.app')

@section('title')
    Classes
@endsection

@php
    $menuItems = [['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.dashboard')],
    ['label' => 'Resources', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.resources.index')]];
@endphp

@section('sidebar')
    @include('components.sidebar', ['menuItems' => $menuItems])
@endsection

@section('content')
    @include('components.profile')

    <div class="p-3 text-[#667085] my-8">
        <i class="fa-solid fa-house mx-2"></i>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="#" class="mx-2 cursor-pointer">Classes</a>
    </div>

    <!-- Display Chapters -->
    <div class="flex flex-wrap ">
        @if (count($classesTeachers) == 0)
            <div class="mx-auto text-gray-500">
                No Classes Assigned to this user
            </div>
        @endif
        {{-- @foreach ($classesTeachers as $classesTeacher)
            <div class="w-full sm:w-1/2 lg:w-1/4 p-3">
                <a href="{{ route('assessments.index', ['class_id' => $classesTeacher->class->id]) }}" class=" bg-white ">

                    <div class="p-4">
                        <img src="{{ $classesTeacher->class->image ? asset($classesTeacher->class->image) : asset('images/default-material.png') }}"
                            alt="{{ $classesTeacher->class->name }}" class="object-cover w-full  rounded-md">
                    </div>
                    <h3 class="px-4 py-2 text-lg font-bold">{{ $classesTeacher->class->name }}</h3>
                </a>
            </div>
        @endforeach --}}
        @foreach ($classesTeachers as $classesTeacher)
            <div class="w-full sm:w-1/2 lg:w-1/4 p-3">
                <a href="{{ route('students_classess', ['class_id' => $classesTeacher->class->id]) }}" class="bg-white">
                    <!-- Chapter Image -->
                    <div class="p-4">
                        <img src="{{ $classesTeacher->class->image ? asset($classesTeacher->class->image) : asset('images/defaultCard.webp') }}"
                            alt="{{ $classesTeacher->class->name }}" class="object-cover w-full rounded-md">
                    </div>
                    <h3 class="px-4 py-2 text-lg font-bold">{{ $classesTeacher->class->name }}</h3>
                </a>
            </div>
        @endforeach
    </div>
@endsection
