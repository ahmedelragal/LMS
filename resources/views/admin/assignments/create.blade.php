@extends('admin.layouts.layout')

@section('content')
<div class="container">
    <h1>Create Assignment</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('assignments.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="school_id" class="form-label">Select School</label>
            <select name="school_id" id="school_id" class="form-control" required>
                <option value="">--Select School--</option>
                @foreach ($schools as $school)
                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="stage_id" class="form-label">Select Stage</label>
            <select name="stage_id" id="stage_id" class="form-control" required>
                <option value="">--Select Stage--</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="student_ids" class="form-label">Select Students</label>
            <select name="student_ids[]" id="student_ids" class="form-control" multiple required>
                <option value="">--Select Students--</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Assignment Title</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}"
                required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Assignment Description</label>
            <textarea name="description" class="form-control" id="summernote">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="path_file" class="form-label">File Upload</label>
            <input type="file" name="path_file" class="form-control" id="path_file">
        </div>

        <div class="mb-3">
            <label for="link" class="form-label">Link</label>
            <input type="url" name="link" class="form-control" id="link" value="{{ old('link') }}">
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" class="form-control" id="start_date"
                value="{{ old('start_date') }}">
        </div>

        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" name="due_date" class="form-control" id="due_date" value="{{ old('due_date') }}">
        </div>

        <div class="mb-3">
            <label for="lesson_id" class="form-label">Select Lesson</label>
            <select name="lesson_id" id="lesson_id" class="form-control" required>
                @foreach ($lessons as $lesson)
                    <option value="{{ $lesson->id }}">{{ $lesson->title }}</option>
                @endforeach
            </select>
        </div>


        <div class="mb-3">
            <label for="marks" class="form-label">Marks</label>
            <input type="number" name="marks" class="form-control" id="marks" value="{{ old('marks') }}">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1">
            <label class="form-check-label" for="is_active">Active</label>
        </div>

        <button type="submit" class="btn btn-primary">Create Assignment</button>
    </form>
</div>
@endsection
@section('page_js')

<!-- Include Summernote JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script> --}}

<script>
    console.log('kkkk');
</script>
<script>
    document.getElementById('school_id').addEventListener('change', function() {
        let schoolId = this.value;
        fetch(`/LMS/lms_pyramakerz/public/admin/api/schools/${schoolId}/stages`)
            .then(response => response.json())
            .then(data => {
                let stageSelect = document.getElementById('stage_id');
                stageSelect.innerHTML = '<option value="">--Select Stage--</option>';
                data.forEach(stage => {
                    stageSelect.innerHTML += `<option value="${stage.id}">${stage.name}</option>`;
                });
            });
    });

    document.getElementById('stage_id').addEventListener('change', function() {
        let stageId = this.value;
        fetch(`/LMS/lms_pyramakerz/public/admin/api/stages/${stageId}/students`)
            .then(response => response.json())
            .then(data => {
                let studentSelect = document.getElementById('student_ids');
                studentSelect.innerHTML = '<option value="">--Select Students--</option>';
                data.forEach(student => {
                    studentSelect.innerHTML +=
                        `<option value="${student.id}">${student.username}</option>`;
                });
            });
    });
</script>

{{-- <script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 200
        });
    });
</script> --}}
@endsection
