@extends('layouts.app')

@section('title')
    Assessments
@endsection

@php
    $menuItems = [
        ['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.dashboard'),
        ['label' => 'Resources', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.resources.index')]],
    ];

@endphp

@section('sidebar')
    @include('components.sidebar', ['menuItems' => $menuItems])
@endsection


@section('content')
    @include('components.profile')

    <div class="p-3 flex justify-between items-center">
        <div class="text-[#667085] my-8">
            <i class="fa-solid fa-house mx-2"></i>
            <span class="mx-2 text-[#D0D5DD]">/</span>
            <a href="{{ route("teacher_classes") }}" class="mx-2 cursor-pointer">Classes</a>
            <span class="mx-2 text-[#D0D5DD]">/</span>
            <a href="#" class="mx-2 cursor-pointer">Assessments</a>
        </div>
        <a class="bg-white border-2 border-[#FF7519] p-2 text-gray-600 font-semibold rounded-md" href="{{ route("assessments.create") }}">Add Student Assessment</a>
    </div>

    <div class="p-3">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-2xl border border-[#EAECF0]">
            <table class="w-full table-auto bg-[#FFFFFF] text-left text-[#475467] text-lg md:text-xl">  
                <thead class="bg-[#F9FAFB]">  
                    <tr>
                        <th class="py-4 px-6 min-w-[220px] whitespace-nowrap">Student</th>
                        <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Attendance (Max 10)</th>
                        <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Classroom Participation (Max 15)</th>
                        <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Classroom Behavior (Max 15)</th>
                        <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Homework (Max 10)</th>
                        <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Final Project (Max 50)</th>
                        <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($students) === 0)
                        <tr>
                            <td colspan="7" class="px-4 py-4 h-[72px] text-center border-t border-gray-300 text-lg md:text-xl">No Data Found</td>
                        </tr>
                    @endif
                    @foreach ($students as $i => $student)
                        <tr class="border-t border-gray-300 text-lg md:text-xl {{ $i % 2 === 0 ? 'bg-[#F4F4F4]' : 'bg-white' }}">
                            <td class="py-5 px-6 text-[#FF7519]">
                                <!-- Make the student's name a clickable link -->
                                <a href="{{ route('teacher.assessments.student', $student->id) }}">
                                    {{ $student->username }}
                                </a>
                            </td>
                            @php
                                // Get the latest assessment for this student
                                $assessment = $student->studentAssessment->first(); // Get the first assessment (latest) for this student
                            @endphp
                            <td class="py-5 px-6">
                                <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                    {{ $assessment->attendance_score ?? '--' }} / 10
                                </div>
                            </td>
                            <td class="py-5 px-6">
                                <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                    {{ $assessment->classroom_participation_score ?? '--' }} / 15
                                </div>
                            </td>
                            <td class="py-5 px-6">
                                <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                    {{ $assessment->classroom_behavior_score ?? '--' }} / 15
                                </div>
                            </td>
                            <td class="py-5 px-6">
                                <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                    {{ $assessment->homework_score ?? '--' }} / 10
                                </div>
                            </td>
                            <td class="py-5 px-6">
                                <div class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                    {{ $assessment->final_project_score ?? '--' }} / 50
                                </div>
                            </td>
                            <td class="py-5 px-6 text-center">
                                <a href="{{ route('teacher.assessments.student', $student->id) }}"
                                    class="btn btn-info"><i class="text-[#FF7519] fa-solid fa-eye"></i></a>
                                {{-- <a href="{{ route('teacher.assessments.edit', $student->id) }}"
                                    class="btn btn-info"><i class="ml-2 fa-solid fa-pen-to-square"></i></a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
