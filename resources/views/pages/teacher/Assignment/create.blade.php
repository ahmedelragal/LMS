@extends('layouts.app')
@section('title')
    Teacher
@endsection
@php
    $menuItems = [
        ['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.dashboard')],
        ['label' => 'Resources', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.resources.index')],
    ];

    $fileExErr = false;
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
            <a href="#" class="mx-2 cursor-pointer">Create Assignment</a>
        </div>
    </div>

    <div class="p-3">
        <div>
            <h1 class="font-semibold text-2xl md:text-3xl">Create Assignment</h1>
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
        <form action="{{ route('assignments.store') }}" method="POST" enctype="multipart/form-data" class="mt-5"
            id="form">
            @csrf
            <div class="mb-3 border border-[#ECECEC] rounded-lg p-4 md:p-8 shadow-md shadow-[#0000001F]">
                <label for="title"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C]">Assignment Title</label>
                <input type="text" name="title"
                    class="border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="title"
                    value="{{ old('title') }}" required>

                <label for="description"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Assignment
                    Description</label>
                <textarea name="description"
                    class="form-control border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base" id="summernote">{{ old('description') }}</textarea>

                <label for="start_date"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Start Date</label>
                <input type="date" name="start_date" id="start_date"
                    class="form-control border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base"
                    value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}" required>
                <label for="due_date" class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Due
                    Date</label>
                <input type="date" name="due_date" id="due_date"
                    class="form-control border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base"
                    value="{{ old('due_date') }}" min="{{ date('Y-m-d', strtotime('+1 year')) }}" required>

                <label for="week"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Select Week</label>
                <select name="week" id="week"
                    class="form-control w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl" required>
                    <option value="">--Select Week--</option>

                    <option value="1">week 1</option>
                    <option value="2">week 2</option>
                    <option value="3">week 3</option>
                    <option value="4">week 4</option>
                    <option value="5">week 5</option>
                    <option value="6">week 6</option>
                    <option value="7">week 7</option>
                    <option value="8">week 8</option>

                </select>
                <label for="stage_id"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Select Stage</label>
                <select name="stage_id" id="stage_id"
                    class="form-control w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl" required>
                    <option value="">--Select Stage--</option>
                    @foreach ($stages as $stage)
                        <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                    @endforeach
                </select>

                <label for="class_ids"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Select
                    Classes</label>

                <select name="class_ids[]" id="class_ids"
                    class="flex justify-between items-center w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl cursor-pointer"
                    multiple required>
                    @foreach ($classes as $class)
                        <option value="">--Select Classes--</option>
                        <option value="{{ $class->class->id }}">{{ $class->class->name }}</option>
                    @endforeach
                </select>

                <label for="lesson_id"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Select Lesson</label>
                {{-- <select name="lesson_id" id="lesson_id"
                    class="form-control w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl" required>
                    <option value="">--Select Lesson--</option>
                    @foreach ($lessons as $lesson)
                        <option value="{{ $lesson->id }}">{{ $lesson->title }}</option>
                    @endforeach
                </select> --}}
                <select name="lesson_id" id="lesson_id"
                    class="form-control w-full p-2 md:p-4 border border-[#E5E5EA] rounded-xl" required>
                    <option value="">--Select Lesson--</option>
                    @foreach ($lessons as $lesson)
                        @php
                            $theme = $lesson->chapter->unit->material->title ?? 'No Theme';
                            $unit = $lesson->chapter->unit->title ?? 'No Unit';
                            $chapter = $lesson->chapter->title ?? 'No Chapter';
                        @endphp
                        <option value="{{ $lesson->id }}">
                            {{ $theme }} > {{ $unit }} > {{ $chapter }} > {{ $lesson->title }}
                        </option>
                    @endforeach
                </select>

                <label for="marks"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Marks</label>


                <input type="number" name="marks" id="marks"
                    class="form-control border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base"
                    value="{{ old('marks') }}" min="1" maxlength="2" max="50" required>

                <label for="path_file"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">File Upload</label>
                <input type="file" name="path_file"
                    class="form-control border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base"
                    id="path_file" accept=".xlsx, .xls, .pdf, .doc, .docx">
                <span id="fileErr" class="text-red-500 ml-3 font-normal hidden">*Invalid File, Allow only .xlsx, .xls,
                    .pdf, .doc, .docx</span>
                <label for="link"
                    class="form-label block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-5">Link</label>
                <input type="url" name="link"
                    class="form-control border border-[#E5E5EA] rounded-lg w-full p-2 md:p-4 text-xs md:text-base"
                    id="link" value="{{ old('link') }}">

                <div class="flex items-center mt-5">
                    <input type="checkbox" name="is_active"
                        class="form-check-input block mb-3 font-semibold text-xs md:text-sm text-[#3A3A3C] mt-3"
                        id="is_active" value="1">
                    <label class="form-check-label ml-3" for="is_active">Active</label>
                </div>

                <button type="submit"
                    class="bg-[#17253E] mt-5 text-white font-bold text-xs md:text-sm py-2 md:py-3 px-4 md:px-5 rounded-lg">Create
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
        function filterNumericInput(event) {
            const input = event.target;
            let previousValue = input.value;

            input.value = input.value.replace(/[^0-9.]/g, '');

            if (input.value.split('.').length > 2) {
                input.value = previousValue;
            }
        }
        document.getElementById('start_date').addEventListener('change', function() {
            const startDate = this.value;
            document.getElementById('due_date').min = startDate;
        });

        document.getElementById('due_date').addEventListener('change', function() {
            const dueDate = this.value;
            document.getElementById('start_date').max = dueDate;
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
