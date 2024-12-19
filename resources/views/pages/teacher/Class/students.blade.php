@extends('layouts.app')

@section('title')
    Teacher Dashboard
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
        <a href="" class="mx-2 cursor-pointer">Assessments</a>
        <span class="mx-2 text-[#D0D5DD]">/</span>
        <a href="" class="mx-2 cursor-pointer">{{ $class->name }}</a>
    </div>

    <div class="">
        <div class="mt-5 overflow-x-auto rounded-2xl border border-[#EAECF0]">
            <table class="w-full table-auto bg-[#FFFFFF] text-left text-[#475467] text-lg md:text-xl">
                <thead class="bg-[#F9FAFB]">
                    <tr>
                        <th class="py-4 px-6 min-w-[220px] whitespace-nowrap">Assessment Type</th>
                        @foreach ($weeks as $week)
                            <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Week {{ $week }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t border-gray-300 text-lg md:text-xl">
                        <td class="py-5 px-6 font-bold">Name</td>
                        @foreach ($students as $student)
                        @dd($student)
                            {{-- <td class="py-5 px-6 text-blue-600">{{ $student->username }}</td> --}}
                        @endforeach
                    </tr>

                    @foreach (['attendance' => 'ATT', 'participation' => 'CP', 'behavior' => 'CB', 'homework' => 'HW', 'final_project' => 'Final Project'] as $field => $label)
                        <tr class="border-t border-gray-300 text-lg md:text-xl">
                            <td class="py-5 px-6 font-bold">{{ $label }}</td>
                            @foreach ($students as $student)
                                <td class="py-5 px-6">
                                    <input type="number" class="w-[40px] assessment-input"
                                        value="{{ $student->assessments[$field] ?? 0 }}"
                                        data-student-id="{{ $student->id }}" data-field="{{ $field }}"
                                        placeholder="Enter score">
                                    <p>/{{ $field == 'attendance' ? 10 : ($field == 'homework' ? 10 : ($field == 'final_project' ? 50 : 20)) }}
                                    </p>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('page_js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.assessment-input');
            inputs.forEach(input => {
                input.addEventListener('change', function() {
                    const studentId = this.dataset.studentId;
                    const field = this.dataset.field;
                    const value = this.value;

                    
                    // Send AJAX request to save the assessment
                    fetch("{{ route('teacher.storeAssessment') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                student_id: studentId,
                                [field]: value
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.message);
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
        });
    </script>
@endsection
