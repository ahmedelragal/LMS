@extends('admin.layouts.layout')

@section('content')
<div class="wrapper">
    @include('admin.layouts.sidebar')

    <div class="main">
        @include('admin.layouts.navbar')

        <main class="content">
            <div class="container-fluid p-0">

                <h2>Homework Report</h2>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('classes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Report For</label>
                        <select name="report_for" id="report_for" class="form-control" required>
                            <option value="school">School</option>
                            <option value="grade">Grade</option>
                            <option value="class">Class</option>
                            <option value="teacher">Teacher</option>
                            <option value="students">Students</option>
                        </select>
                    </div>
                    <div class="mb-3" id="school_select">
                        <label for="school_id" class="form-label">School</label>
                        <select name="school_id" id="school_id" class="form-control" required>
                            <option selected disabled hidden></option>
                            @foreach ($schools as $school)
                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3" id="grade_select" hidden>
                        <label for="stage_id" class="form-label">Grade</label>
                        <select name="stage_id" id="stage_id" class="form-control" required>
                            <option selected disabled hidden></option>
                            @foreach ($stages as $stage)
                            <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3" id="class_select" hidden>
                        <label for="class_id" class="form-label">Class</label>
                        <select name="class_id" id="class_id" class="form-control" required>
                            <option selected disabled hidden></option>
                            @foreach ($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3" id="teacher_select" hidden>
                        <label for="teacher_id" class="form-label">Teacher</label>
                        <select name="teacher_id" id="teacher_id" class="form-control" required>
                            <option selected disabled hidden></option>
                            @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->username }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3" id="student_select" hidden>
                        <label for="student_id" class="form-label">Student</label>
                        <select name="student_id" id="student_id" class="form-control" required>
                            <option selected disabled>Please Select School</option>

                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Class</button>
                </form>

            </div>
        </main>


    </div>
</div>
@endsection

@section('page_js')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const reportFor = document.getElementById('report_for');
        const schoolSelect = document.getElementById('school_select');
        const gradeSelect = document.getElementById('grade_select');
        const classSelect = document.getElementById('class_select');
        const teacherSelect = document.getElementById('teacher_select');
        const studentSelect = document.getElementById('student_select');

        // Add a change event listener to the 'report_for' dropdown
        reportFor.addEventListener('change', function() {

            // schoolSelect.hidden = true;
            gradeSelect.hidden = true;
            classSelect.hidden = true;
            teacherSelect.hidden = true;
            studentSelect.hidden = true;

            switch (this.value) {
                case 'school':
                    schoolSelect.hidden = false;
                    break;
                case 'grade':
                    gradeSelect.hidden = false;
                    break;
                case 'class':
                    classSelect.hidden = false;
                    break;
                case 'teacher':
                    teacherSelect.hidden = false;
                    break;
                case 'students':
                    studentSelect.hidden = false;
                    break;
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.js-select2').select2();

        // // Get previously selected program_id from localStorage if exists


        // Trigger getProgramsByGroup on group change
        $('#school_id').change(function() {
            var schoolId = $('#school_id').val();
            getSchoolStudents(schoolId);
        });


        // Trigger change on page load to fetch programs for the selected group
        $('#school_id').trigger('change');
    });


    function getSchoolStudents(schoolId) {
        $.ajax({
            url: '/admin/get-students-school/' + schoolId,
            type: "GET",
            dataType: "json",
            success: function(data) {
                // Clear the existing options
                $('select[name="student_id"]').empty();
                if (!data || data.length === 0) {
                    $('select[name="student_id"]').append(
                        '<option value="" selected disabled>No Available Students</option>'
                    );
                } else {
                    $('select[name="student_id"]').append(
                        '<option value="" selected disabled>Choose a Student</option>'
                    );
                    $.each(data, function(key, value) {
                        $('select[name="student_id"]').append(
                            '<option value="' + value.id + '">' + value.username + '</option>'
                        );
                    });

                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
            }
        });
    }
</script>

@endsection