@extends('layouts.app')


@section('title')
    Teacher Dashboard
@endsection
@php
    use Carbon\Carbon;
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
        {{-- <a href="{{ route('teacher_classes', $id) }}" class="mx-2 cursor-pointer">Classes</a> --}}
        {{-- <span class="mx-2 text-[#D0D5DD]">/</span> --}}
        <a href="#" class="mx-2 cursor-pointer">Class Assessments</a>
    </div>


    <div class="">

        <div class="mt-5 overflow-x-auto rounded-2xl border border-[#EAECF0]">
            <table class="w-full table-auto bg-[#FFFFFF] text-[#475467] text-lg md:text-xl text-center">
                <thead class="bg-[#F9FAFB]">
                    <tr>
                        <th class="py-4 px-6 min-w-[220px] whitespace-nowrap">Name</th>
                        <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">ATT</th>
                        <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">CP</th>
                        <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">CB</th>
                        <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">H.W</th>
                        <th class="py-4 px-6 min-w-[120px] whitespace-nowrap">Final Project</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($students) === 0)
                        <tr>
                            <td colspan="6"
                                class="px-4 py-4 h-[72px] text-center border-t border-gray-300 text-lg md:text-xl">No Data
                                Found</td>
                        </tr>
                    @endif

                    @foreach ($students as $student)
                        @foreach ($student as $s)
                            @php
                                $countattendance_score = $s->studentAssessment
                                    ->whereNotNull('attendance_score')
                                    ->count();
                                $countclassroom_participation_score = $s->studentAssessment
                                    ->whereNotNull('classroom_participation_score')
                                    ->count();
                                $countclassroom_behavior_score = $s->studentAssessment
                                    ->whereNotNull('classroom_behavior_score')
                                    ->count();
                                $counthomework_score = $s->studentAssessment->whereNotNull('homework_score')->count();

                                // Check if any of the counts are non-zero to prevent division by zero.
                                if (
                                    $countattendance_score !== 0 ||
                                    $countclassroom_participation_score !== 0 ||
                                    $countclassroom_behavior_score !== 0 ||
                                    $counthomework_score !== 0
                                ) {
                                    $attendance_score = $s->studentAssessment
                                        ->whereNotNull('attendance_score')
                                        ->sum('attendance_score');
                                    $attendance_avg = $countattendance_score
                                        ? intval($attendance_score / $countattendance_score)
                                        : 0;

                                    $cp_score = $s->studentAssessment
                                        ->whereNotNull('classroom_participation_score')
                                        ->sum('classroom_participation_score');
                                    $cp_avg = $countclassroom_participation_score
                                        ? intval($cp_score / $countclassroom_participation_score)
                                        : 0;

                                    $cb_score = $s->studentAssessment
                                        ->whereNotNull('classroom_behavior_score')
                                        ->sum('classroom_behavior_score');

                                    $cb_avg = $countclassroom_behavior_score
                                        ? min(10, intval($cb_score / $countclassroom_behavior_score))
                                        : 0;

                                    $hw_score = $s->studentAssessment
                                        ->whereNotNull('homework_score')
                                        ->sum('homework_score');
                                    $hw_avg = $counthomework_score ? intval($hw_score / $counthomework_score) : 0;
                                } else {
                                    $attendance_avg = 0;
                                    $cp_avg = 0;
                                    $cb_avg = 0;
                                    $hw_avg = 0;
                                }
                            @endphp


                            <tr class="border-t border-gray-300 text-lg md:text-xl">
                                <td class="py-5 px-6" rowspan="2">
                                    <a href="{{ route('teacher.assessments.student', $s->id) }}"
                                        class="text-blue-600 hover:underline">
                                        {{ $s->username ?? '' }}
                                    </a>
                                </td>
                                <td class="py-5 px-6">
                                    <div
                                        class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                        <p class="mr-1">{{ $attendance_avg ?? '' }}</p>
                                        <p>/10</p>
                                    </div>
                                </td>
                                <td class="py-5 px-6">
                                    <div
                                        class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                        <p class="mr-1">{{ $cp_avg ?? '' }}</p>
                                        <p>/20</p>
                                    </div>
                                </td>
                                <td class="py-5 px-6">
                                    <div
                                        class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                        <p class="mr-1">{{ $cb_avg ?? '' }}</p>
                                        <p>/20</p>
                                    </div>
                                </td>
                                <td class="py-5 px-6">
                                    <div
                                        class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                        <p class="mr-1">{{ $hw_avg ?? '' }}</p>
                                        <p>/10</p>
                                    </div>
                                </td>
                            </tr>
                            @foreach ($s->studentAssessment as $studentDegree)
                                @php
                                    $now = Carbon::now();
                                    $isSameWeek = $studentDegree->created_at->isSameWeek($now);
                                    $last_att_score = $studentDegree->attendance_score;

                                    if ($isSameWeek) {
                                        $last_att_score = $studentDegree->attendance_score;
                                        $last_cp_score = $studentDegree->classroom_participation_score;
                                        $last_cb_score = $studentDegree->classroom_behavior_score;
                                        $last_hw_score = $studentDegree->homework_score;
                                        $last_final_score = $studentDegree->final_project_score;
                                        break;
                                    } else {
                                        $last_att_score = $last_cp_score = $last_cb_score = $last_hw_score = $last_final_score = null;
                                    }
                                @endphp
                            @endforeach
                            <tr class="border-t border-gray-300 text-lg md:text-xl bg-[#DFE6FF]">
                                <td class="py-5 px-6">
                                    <div
                                        class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                        <input class="w-[40px] assessment-input" max="10" min="0"
                                            type="number" name="attendance_score" data-student-id="{{ $s->id }}"
                                            value="{{ $last_att_score ?? null }}" oninput="filterNumericInput(event)">
                                        <p>/10 </p>
                                    </div>
                                </td>
                                <td class="py-5 px-6">
                                    <div
                                        class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                        <input class="w-[40px] assessment-input" type="number" max="20"
                                            min="0" name="classroom_participation_score"
                                            data-student-id="{{ $s->id }}" value="{{ $last_cp_score ?? null }}"
                                            oninput="filterNumericInput(event)">
                                        <p>/20 </p>
                                    </div>
                                </td>
                                <td class="py-5 px-6">
                                    <div
                                        class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                        <input class="w-[40px] assessment-input" type="number" max="20"
                                            min="0" name="classroom_behavior_score"
                                            data-student-id="{{ $s->id }}" value="{{ $last_cb_score ?? null }}"
                                            oninput="filterNumericInput(event)">
                                        <p>/20 </p>
                                    </div>
                                </td>
                                <td class="py-5 px-6">
                                    <div
                                        class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                        <input class="w-[40px] assessment-input" type="number" name="homework_score"
                                            max="10" min="0" data-student-id="{{ $s->id }}"
                                            value="{{ $last_hw_score ?? null }}" oninput="filterNumericInput(event)">
                                        <p>/10 </p>
                                    </div>
                                </td>
                                <td class="py-5 px-6">
                                    <div
                                        class="bg-white w-[90px] mx-auto p-2 rounded-md border-2 border-gray-300 flex items-center justify-center">
                                        <input class="w-[40px] assessment-input" type="number" name="final_project_score"
                                            max="50" min="0" data-student-id="{{ $s->id }}"
                                            value="{{ $last_final_score ?? null }}" oninput="filterNumericInput(event)">
                                        <p>/50 </p>
                                    </div>
                                </td>
                            </tr>

                            @if ($loop->index != count($students) - 1)
                                <tr class="bg-white border border-x border-x-white">
                                    <td colspan="6" class="p-0">
                                        <div class="h-10 bg-transparent"></div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
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
                    const fieldName = this.name;
                    const value = this.value;

                    const data = {
                        student_id: studentId,
                        [fieldName]: value
                        // week: 8 // You can dynamically pass the week or change it accordingly.
                    };

                    // Send AJAX request to save the assessment
                    fetch("{{ route('teacher.storeAssessment') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // alert(data.message);
                            } else {
                                alert('Error saving the assessment');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
        });
        // document.addEventListener('DOMContentLoaded', function() {
        //     const inputs = document.querySelectorAll('.assessment-input');
        //     inputs.forEach(input => {
        //         input.addEventListener('change', function() {
        //             const studentId = this.dataset.studentId;
        //             const fieldName = this.name;
        //             const value = this.value;
        //             const week = this.dataset.week; // Dynamically set the week

        //             const data = {
        //                 student_id: studentId,
        //                 [fieldName]: value,
        //                 week: week // Pass the week dynamically
        //             };

        //             fetch("{{ route('teacher.storeAssessment') }}", {
        //                     method: 'POST',
        //                     headers: {
        //                         'Content-Type': 'application/json',
        //                         'X-CSRF-TOKEN': '{{ csrf_token() }}'
        //                     },
        //                     body: JSON.stringify(data)
        //                 })
        //                 .then(response => response.json())
        //                 .then(data => {
        //                     if (!data.success) {
        //                         alert('Error saving the assessment');
        //                     }
        //                 })
        //                 .catch(error => {
        //                     console.error('Error:', error);
        //                 });
        //         });
        //     });
        // });

        function filterNumericInput(event) {
            const input = event.target;
            let previousValue = input.value;

            input.value = input.value.replace(/[^0-9.]/g, '');

            if (input.value.split('.').length > 2) {
                input.value = previousValue;
            }
        }
    </script>
@endsection
