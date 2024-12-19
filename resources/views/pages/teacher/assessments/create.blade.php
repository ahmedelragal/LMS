@extends('layouts.app')

@section('title')
    Add Student Assessment
@endsection

@php
    $menuItems = [
        ['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.dashboard')],
        ['label' => 'Resources', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.resources.index')]
    ];

@endphp

@section('sidebar')
    @include('components.sidebar', ['menuItems' => $menuItems])
@endsection


@section('content')

    @include('components.profile')

    <div class="p-3">
        <div class="text-[#667085] my-8">
            <i class="fa-solid fa-house mx-2"></i>
            <span class="mx-2 text-[#D0D5DD]">/</span>
            <a href="{{ route("teacher_classes") }}" class="mx-2 cursor-pointer">Classes</a>
            <span class="mx-2 text-[#D0D5DD]">/</span>
            <a href="{{ route('assessments.index', ['class_id' => $classId]) }}" class="mx-2 cursor-pointer">Assessments</a>
            <span class="mx-2 text-[#D0D5DD]">/</span>
            <a href="#" class="mx-2 cursor-pointer">Add Student Assessment</a>
        </div>
    </div>

    <div class="p-3">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('assessments.store') }}" method="POST">
            @csrf

            @foreach ($students as  $i => $student)
                <div class="{{ $i !== count($students) - 1 ? 'mb-10' : '' }} border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F] mb-3">
                    <div class="font-bold text-xl text-[#17253E] w-full border-2 p-4">
                        {{ $student->username }} ({{ $student->school->name }}, {{ $student->stage->name }})
                    </div>
                    <div class="mt-3 w-full">
                        <input type="hidden" name="assessments[{{ $loop->index }}][student_id]"
                            value="{{ $student->id }}">

                        <div class="mb-3 flex items-center">
                            <div class="w-1/2">
                                <label for="attendance_score_{{ $student->id }}" class="mb-1 font-semibold text-[#3A3A3C]">Attendance Score (Max
                                    10)</label>
                            </div>
                            <input type="number" name="assessments[{{ $loop->index }}][attendance_score]"
                                id="attendance_score_{{ $student->id }}" class="w-full border border-[#E5E5EA] rounded-lg p-2 md:p-4 text-xs md:text-base" max="10">
                        </div>

                        <div class="mb-3 flex items-center">
                            <div class="w-1/2">
                                <label for="classroom_participation_score_{{ $student->id }}" class="mb-1 font-semibold text-[#3A3A3C]">Classroom
                                    Participation Score (Max 15)</label>
                            </div>
                            <input type="number" name="assessments[{{ $loop->index }}][classroom_participation_score]"
                                id="classroom_participation_score_{{ $student->id }}" class="w-full border border-[#E5E5EA] rounded-lg p-2 md:p-4 text-xs md:text-base" max="15">
                        </div>

                        <div class="mb-3 flex items-center">
                            <div class="w-1/2">
                                <label for="classroom_behavior_score_{{ $student->id }}" class="mb-1 font-semibold text-[#3A3A3C]">Classroom Behavior
                                    Score (Max 15)</label>
                            </div>
                            <input type="number" name="assessments[{{ $loop->index }}][classroom_behavior_score]"
                                id="classroom_behavior_score_{{ $student->id }}" class="w-full border border-[#E5E5EA] rounded-lg p-2 md:p-4 text-xs md:text-base" max="15">
                        </div>

                        <div class="mb-3 flex items-center">
                            <div class="w-1/2">
                                <label for="homework_score_{{ $student->id }}" class="mb-1 font-semibold text-[#3A3A3C]">Homework Score (Max
                                    10)</label>
                            </div>
                            <input type="number" name="assessments[{{ $loop->index }}][homework_score]"
                                id="homework_score_{{ $student->id }}" class="border w-full border-[#E5E5EA] rounded-lg p-2 md:p-4 text-xs md:text-base" max="10">
                        </div>

                        <div class="mb-3 flex items-center">
                            <div class="w-1/2">
                                <label for="final_project_score_{{ $student->id }}" class="mb-1 font-semibold text-[#3A3A3C]">Final Project Score
                                    (Max 50)
                                </label>
                            </div>
                            <input type="number" name="assessments[{{ $loop->index }}][final_project_score]"
                                id="final_project_score_{{ $student->id }}" class="w-full border border-[#E5E5EA] rounded-lg p-2 md:p-4 text-xs md:text-base" max="50">
                        </div>
                    </div>
                </div>
            @endforeach

            <button type="submit" class="rounded-md px-6 py-3 bg-[#17253E] text-white border-none mt-5">Submit Assessments</button>
        </form>
    </div>

@endsection
