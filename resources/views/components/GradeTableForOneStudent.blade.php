@extends('layouts.app')

@section('title')
    Teacher Dashboard
@endsection
@php

    $menuItems = [['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.dashboard')],
    ['label' => 'Resources', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.resources.index')]];

    $tableData = [
        [
            'records' => [
                [
                    'attendance' => 9,
                    'participation' => 18,
                    'behavior' => 20,
                    'homework' => 8,
                    'final_project' => 45,
                ],
                [
                    'attendance' => 8,
                    'participation' => 19,
                    'behavior' => 17,
                    'homework' => 9,
                    'final_project' => 48,
                ],
                // Add more records as needed
            ],
        ],
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
        {{-- <a href="{{ route('teacher_classes') }}" class="mx-2 cursor-pointer">Classes</a> --}}
        {{-- <span class="mx-2 text-[#D0D5DD]">/</span> --}}
        <a href="{{ route('students_classess', ['class_id' => $classId]) }}" class="mx-2 cursor-pointer">Class Assessments</a>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="#" class="mx-2 cursor-pointer">{{ $student2->username }}</a>
    </div>

    <div class="">

        <div class="mt-5 overflow-x-auto rounded-2xl border border-[#EAECF0]">
            <table class="w-full table-auto bg-[#FFFFFF] text-[#475467] text-lg md:text-xl text-center">
                <thead class="bg-[#F9FAFB]">
                    <tr>
                        <th class="py-4 px-6 min-w-[220px] whitespace-nowrap">Name</th>
                        <th class="py-4 px-6 min-w-[220px] whitespace-nowrap">Week</th>
                        <th class="py-4 px-6 min-w-[220px] whitespace-nowrap">Date</th>
                        <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Attendance</th>
                        <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Classroom Participation</th>
                        <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Classroom Behavior</th>
                        <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Homework</th>
                        <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Final Project</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $weekNumber = 1;
                    @endphp
                    @foreach ($assessments as $student)
                        @if ($loop->index == 0)
                            <tr class="bg-white">
                                <td class="bg-white p-5" rowspan="{{ count($assessments) }}">{{ $student2->username }}</td>
                                <td class="py-5 px-6"> <span>Week {{ $weekNumber }}</span> </td>
                                <td class="py-5 px-6">

                                    [{{ Carbon\Carbon::parse(date('Y-m-d', strtotime($student->created_at)))->startOfWeek()->format('d-m') }}]
                                    :
                                    [{{ Carbon\Carbon::parse(date('Y-m-d', strtotime($student->created_at)))->endOfWeek()->format('d-m') }}]
                                </td>
                                <td class="py-5 px-6">
                                    <div
                                        class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                        <input class="w-[40px]" readonly type="number"
                                            value="{{ $student->attendance_score ? $student->attendance_score : 0 }}">
                                        <p>/10 </p>
                                    </div>
                                </td>
                                <td class="py-5 px-6">
                                    <div
                                        class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                        <input class="w-[40px]" readonly type="number"
                                            value="{{ $student->classroom_participation_score ? $student->classroom_participation_score : 0 }}">
                                        <p>/20 </p>
                                    </div>
                                </td>
                                <td class="py-5 px-6">
                                    <div
                                        class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                        <input class="w-[40px]" readonly type="number"
                                            value="{{ $student->classroom_behavior_score ? $student->classroom_behavior_score : 0 }}">
                                        <p>/20 </p>
                                    </div>
                                </td>
                                <td class="py-5 px-6">
                                    <div
                                        class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                        <input class="w-[40px]" readonly type="number"
                                            value="{{ $student->homework_score ? $student->homework_score : 0 }}">
                                        <p>/10 </p>
                                    </div>
                                </td>
                                <td class="py-5 px-6" rowspan="{{ count($assessments) }}">
                                    <div
                                        class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                        <input class="w-[40px]" readonly type="number"
                                            value="{{ $student->final_project_score ? $student->final_project_score : 0 }}">
                                        <p>/50 </p>
                                    </div>
                                </td>
                            </tr>
                        @else
                            <tr
                                class="border-t border-gray-300 text-lg md:text-xl {{ $loop->index % 2 === 0 ? 'bg-white' : 'bg-[#DFE6FF]' }}">
                                <td class="py-5 px-6"> <span>Week {{ $weekNumber }}</span> </td>
                                <td class="py-5 px-6">

                                    [{{ Carbon\Carbon::parse(date('Y-m-d', strtotime($student->created_at)))->startOfWeek()->format('d-m') }}]
                                    :
                                    [{{ Carbon\Carbon::parse(date('Y-m-d', strtotime($student->created_at)))->endOfWeek()->format('d-m') }}]
                                </td>
                                <td class="py-5 px-6">
                                    <div
                                        class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                        <input class="w-[40px]" readonly type="number"
                                            value="{{ $student->attendance_score ? $student->attendance_score : 0 }}">
                                        <p>/10 </p>
                                    </div>
                                </td>
                                <td class="py-5 px-6">
                                    <div
                                        class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                        <input class="w-[40px]" readonly type="number"
                                            value="{{ $student->classroom_participation_score ? $student->classroom_participation_score : 0 }}">
                                        <p>/20 </p>
                                    </div>
                                </td>
                                <td class="py-5 px-6">
                                    <div
                                        class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                        <input class="w-[40px]" readonly type="number"
                                            value="{{ $student->classroom_behavior_score ? $student->classroom_behavior_score : 0 }}">
                                        <p>/20 </p>
                                    </div>
                                </td>
                                <td class="py-5 px-6">
                                    <div
                                        class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                        <input class="w-[40px]" readonly type="number"
                                            value="{{ $student->homework_score ? $student->homework_score : 0 }}">
                                        <p>/10 </p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                        @php
                            $weekNumber++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection
