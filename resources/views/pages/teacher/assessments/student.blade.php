@extends('layouts.app')

@section('title')
    Student Assessment
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
            <a href="{{ route("assessments.index", ['class_id' => $classId]) }}" class="mx-2 cursor-pointer">Assessments</a>
            <span class="mx-2 text-[#D0D5DD]">/</span>
            <a href="#" class="mx-2 cursor-pointer">{{ $student->username }}</a>
        </div>
    </div>

    <div class="p-3">
        <div class="overflow-x-auto rounded-2xl border border-[#EAECF0]">
            <table class="w-full table-auto bg-[#FFFFFF] text-left text-[#475467] text-lg md:text-xl">
                <thead class="bg-[#F9FAFB]">  
                    <tr>
                        <th class="py-4 px-6 min-w-[220px] whitespace-nowrap">Date</th>
                        <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Attendance (Max 10)</th>
                        <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Classroom Participation (Max 15)</th>
                        <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Classroom Behavior (Max 15)</th>
                        <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Homework (Max 10)</th>
                        <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Final Project (Max 50)</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($assessments) === 0)
                        <tr>
                            <td colspan="6" class="px-4 py-4 h-[72px] text-center border-t border-gray-300 text-lg md:text-xl">No assessments found for this student.</td>
                        </tr>
                    @endif
                    @foreach($assessments as $assessment)
                        <tr class="border-t border-gray-300 text-lg md:text-xl">
                            <td class="py-5 px-6">
                                {{ $assessment->created_at->format('Y-m-d') }}
                            </td>
                            <td class="py-5 px-6">
                                <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                    {{ $assessment->attendance_score }} / 10
                                </div>
                            </td>
                            <td class="py-5 px-6">
                                <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                    {{ $assessment->classroom_participation_score }} / 15
                                </div>
                            </td>
                            <td class="py-5 px-6">
                                <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                    {{ $assessment->classroom_behavior_score }} / 15
                                </div>
                            </td>
                            <td class="py-5 px-6">
                                <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                    {{ $assessment->homework_score }} / 10
                                </div>
                            </td>
                            <td class="py-5 px-6">
                                <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                    {{ $assessment->final_project_score }} / 50
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
