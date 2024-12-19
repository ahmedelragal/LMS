@extends('layouts.app')
@section('title', 'Edit Assignment')

@php
    $menuItems = [
        ['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.dashboard')],
        ['label' => 'Resources', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.resources.index')],
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
            <a href="{{ route('assignments.index') }}" class="mx-2 cursor-pointer">Assignment</a>
            <span class="mx-2 text-[#D0D5DD]">/</span>
            <a href="#" class="mx-2 cursor-pointer">Edit Assignment</a>
        </div>
    </div>

    <div class="p-3">
        <div>
            <h1 class="font-semibold text-2xl md:text-3xl">Edit Assignment</h1>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('assignments.update', $assignment->id) }}" method="POST" enctype="multipart/form-data"
            class="mt-5" id="form">
            @csrf
            @method('PUT')

            <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">

                <!-- Assignment Title -->
                <label for="title"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C]">Assignment Title</label>
                <input type="text" name="title"
                    class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="title"
                    value="{{ $assignment->title }}" required>

                <!-- Assignment Description -->
                <label for="description"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Assignment
                    Description</label>
                <textarea name="description"
                    class="form-control border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="summernote">{{ $assignment->description }}</textarea>

                <!-- Start Date -->
                <label for="start_date"
                    class="form-label mt-5 block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C]">Start Date</label>
                <input type="date" name="start_date"
                    class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="start_date"
                    value="{{ $assignment->start_date }}">

                <!-- Due Date -->
                <label for="due_date" class="form-label mt-5 block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C]">Due
                    Date</label>
                <input type="date" name="due_date"
                    class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="due_date"
                    value="{{ $assignment->due_date }}">

                <label for="week"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Select Week</label>
                <select name="week" id="week"
                    class="form-control w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl" required>
                    <option value="">--Select Week--</option>

                    <option value="1" {{ $selectedWeek == 1 ? 'selected' : '' }}>week 1</option>
                    <option value="2" {{ $selectedWeek == 2 ? 'selected' : '' }}>week 2</option>
                    <option value="3" {{ $selectedWeek == 3 ? 'selected' : '' }}>week 3</option>
                    <option value="4" {{ $selectedWeek == 4 ? 'selected' : '' }}>week 4</option>
                    <option value="5" {{ $selectedWeek == 5 ? 'selected' : '' }}>week 5</option>
                    <option value="6" {{ $selectedWeek == 6 ? 'selected' : '' }}>week 6</option>
                    <option value="7" {{ $selectedWeek == 7 ? 'selected' : '' }}>week 7</option>
                    <option value="8" {{ $selectedWeek == 8 ? 'selected' : '' }}>week 8</option>

                </select>

                <!-- Select Stage -->
                <label for="stage_id"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Select Stage</label>
                <select name="stage_id" id="stage_id"
                    class="form-control w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl" required>
                    <option value="">--Select Stage--</option>
                    @foreach ($stages as $stage)
                        <option value="{{ $stage->id }}" {{ $selectedStage == $stage->id ? 'selected' : '' }}>
                            {{ $stage->name }}</option>
                    @endforeach
                </select>

                <!-- Select Classes (multiple) -->
                <label for="class_ids"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Select
                    Classes</label>
                <select name="class_ids[]" id="class_ids"
                    class="form-control w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl" multiple required>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}"
                            {{ in_array($class->id, $selectedClasses) ? 'selected' : '' }}>{{ $class->name }}</option>
                    @endforeach
                </select>

                <!-- Select Lesson -->
                <label for="lesson_id"
                    class="form-label block mb-3 font-semibold mt-5 text-xs md:text-sm text-[#3A3A3C]">Select Lesson</label>
                <select name="lesson_id" id="lesson_id"
                    class="form-control w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl" required>
                    @foreach ($lessons as $lesson)
                        <option value="{{ $lesson->id }}" {{ $assignment->lesson_id == $lesson->id ? 'selected' : '' }}>
                            {{ $lesson->title }}</option>
                    @endforeach
                </select>

                <!-- Marks -->
                <label for="marks"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Marks</label>
                <input type="number" name="marks" min="1" max="50"
                    class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="marks"
                    value="{{ $assignment->marks }}">

                <!-- File Upload -->
                <label for="path_file"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm mt-5 text-[#3A3A3C]">File Upload</label>
                <input type="file" name="path_file"
                    class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="path_file"
                    accept=".xlsx, .xls, .pdf, .doc, .docx">
                @if ($assignment->path_file)
                    <p>Current File: <a href="{{ asset($assignment->path_file) }}">Download</a></p>
                @endif
                <span id="fileErr" class="text-red-500 ml-3 font-normal hidden">*Invalid File, Allow only .xlsx, .xls,
                    .pdf, .doc, .docx</span>

                <!-- Link -->
                <label for="link"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Link</label>
                <input type="url" name="link"
                    class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="link"
                    value="{{ $assignment->link }}">

                <!-- Active Checkbox -->
                <div class="flex items-center mt-5">
                    <input type="checkbox" name="is_active"
                        class="form-check-input block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-3"
                        id="is_active" value="1" {{ $assignment->is_active ? 'checked' : '' }}>
                    <label class="form-check-label ml-3" for="is_active">Active</label>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="bg-[#17253E] text-white font-bold text-xs md:text-sm py-2 md:py-3 px-4 md:px-5 rounded-lg mt-5">Update
                    Assignment</button>
            </div>
        </form>
    </div>
@endsection

@section('page_js')
    <script>
        $('#class_ids').select2({
            placeholder: "Select Classes",
            allowClear: true
        });
    </script>
    <script>
        $(document).ready(function() {
            // Initialize Summernote
            $('#summernote').summernote({
                height: 200
            });

            // Initialize Select2 for multiple class selection
            $('#class_ids').select2({
                placeholder: "Select Classes",
                allowClear: true
            });
        });

        const form = document.getElementById('form');
        const fileInput = document.getElementById('path_file');
        const allowedExtensions = ['.xlsx', '.xls', '.pdf', '.doc', '.docx'];

        form.addEventListener('submit', function(event) {
            const file = fileInput.files[0];

            if (file) {
                const fileName = file.name;
                const fileExtension = fileName.substring(fileName.lastIndexOf('.')).toLowerCase();

                if (!allowedExtensions.includes(fileExtension)) {
                    document.getElementById("fileErr")?.classList.remove("hidden");
                    document.getElementById("fileErr")?.classList.add("flex");
                    event.preventDefault();
                }
            }
        });
    </script>
@endsection
