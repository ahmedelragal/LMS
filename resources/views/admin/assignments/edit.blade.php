{{-- @extends('layouts.admin')

@section('content') --}}
<div class="container">
    <h1>Edit Assignment</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('assignments.update', $assignment->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Select School -->
        <div class="mb-3">
            <label for="school_id" class="form-label">Select School</label>
            <select name="school_id" id="school_id" class="form-control" required>
                <option value="">--Select School--</option>
                @foreach ($schools as $school)
                    <option value="{{ $school->id }}" {{ $assignment->school_id == $school->id ? 'selected' : '' }}>
                        {{ $school->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Select Stage (pre-fill the existing stage) -->
        <div class="mb-3">
            <label for="stage_id" class="form-label">Select Stage</label>
            <select name="stage_id" id="stage_id" class="form-control" required>
                <option value="">--Select Stage--</option>
                @foreach ($stages as $stage)
                    <option value="{{ $stage->id }}" {{ $selectedStage == $stage->id ? 'selected' : '' }}>
                        {{ $stage->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Select Students (pre-fill the existing students) -->
        <div class="mb-3">
            <label for="student_ids" class="form-label">Select Students</label>
            <select name="student_ids[]" id="student_ids" class="form-control" multiple required>
                <option value="">--Select Students--</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}"
                        {{ in_array($student->id, $selectedStudents) ? 'selected' : '' }}>
                        {{ $student->username }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Other fields (title, description, file, etc.) -->
        <div class="mb-3">
            <label for="title" class="form-label">Assignment Title</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ $assignment->title }}"
                required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Assignment Description</label>
            <textarea name="description" class="form-control" id="summernote">{{ $assignment->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="lesson_id" class="form-label">Select Lesson</label>
            <select name="lesson_id" id="lesson_id" class="form-control" required>
                <option value="">--Select Lesson--</option>
                @foreach ($lessons as $lesson)
                    <option value="{{ $lesson->id }}" {{ $assignment->lesson_id == $lesson->id ? 'selected' : '' }}>
                        {{ $lesson->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="path_file" class="form-label">File Upload</label>
            <input type="file" name="path_file" class="form-control" id="path_file">
            @if ($assignment->path_file)
                <p>Current File: <a href="{{ asset('storage/' . $assignment->path_file) }}">Download</a></p>
            @endif
        </div>

        <div class="mb-3">
            <label for="link" class="form-label">Link</label>
            <input type="url" name="link" class="form-control" id="link" value="{{ $assignment->link }}">
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" class="form-control" id="start_date"
                value="{{ $assignment->start_date }}">
        </div>

        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" name="due_date" class="form-control" id="due_date"
                value="{{ $assignment->due_date }}">
        </div>

        <div class="mb-3">
            <label for="marks" class="form-label">Marks</label>
            <input type="number" name="marks" class="form-control" id="marks" value="{{ $assignment->marks }}">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1"
                {{ $assignment->is_active ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Active</label>
        </div>

        <button type="submit" class="btn btn-primary">Update Assignment</button>
    </form>
</div>

<!-- Include Summernote JS -->
<script>
    document.getElementById('school_id').addEventListener('change', function() {
        let schoolId = this.value;
        fetch(`/LMS/lms_pyramakerz/public/api/schools/${schoolId}/stages`)
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
        fetch(`/LMS/lms_pyramakerz/public/api/stages/${stageId}/students`)
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

    $(document).ready(function() {
        $('#summernote').summernote({
            height: 200
        });
    });
</script>
{{-- @endsection --}}
