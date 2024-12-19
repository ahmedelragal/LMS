@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h2>Create Teacher</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                            <div class="invalid-feedback" style="display: none;">Username cannot contain numbers.</div>
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select name="gender" id="gender" class="form-control" required>
                                <option selected disabled hidden></option>
                                <option value="boy">Boy</option>
                                <option value="girl">Girl</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="school_id" class="form-label">School</label>
                            <select name="school_id" id="school_id" class="form-control" required>
                                <option value="">-- Select School --</option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="stage_ids" class="form-label">Grades</label>
                            <select name="stage_ids[]" id="stage_ids" class="form-control" multiple required disabled>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="class_ids" class="form-label">Classes</label>
                            <select name="class_id[]" id="class_id" class="form-control" multiple required disabled>
                            </select>
                        </div>



                        <!-- Image Upload -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Profile Image</label>
                            <input type="file" name="image" class="form-control" id="image" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary">Create Teacher</button>
                    </form>

                </div>
            </main>


        </div>
    </div>
@endsection

@section('page_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#stage_ids').select2({
                placeholder: "Select Stages",
                allowClear: true
            });
            $('#class_id').select2({
                placeholder: "Select Classes",
                allowClear: true
            });
        });
    </script>
    <script>
        document.getElementById('school_id').addEventListener('change', function() {
            let schoolId = this.value;
            if (schoolId) {
                const stagesUrl = `{{ route('admin.schools.stages', ':school') }}`.replace(':school', schoolId);

                fetch(stagesUrl)
                    .then(response => response.json())
                    .then(data => {
                        let stageSelect = document.getElementById('stage_ids');
                        stageSelect.innerHTML = '';
                        data.forEach(stage => {
                            stageSelect.innerHTML +=
                                `<option value="${stage.id}">${stage.name}</option>`;
                        });
                        stageSelect.disabled = false;
                    });
            } else {
                document.getElementById('stage_ids').disabled = true;
            }
        });
        document.getElementById('school_id').addEventListener('change', function() {
            let schoolId = this.value;
            if (schoolId) {
                const classesUrl = `{{ route('admin.schools.classes', ':school') }}`.replace(':school', schoolId);

                fetch(classesUrl)
                    .then(response => response.json())
                    .then(data => {
                        let classSelect = document.getElementById('class_id');
                        classSelect.innerHTML = '';
                        data.forEach(classData => {
                            classSelect.innerHTML +=
                                `<option value="${classData.id}">${classData.name}</option>`;
                        });
                        classSelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error fetching classes:', error);
                    });
            } else {
                document.getElementById('class_id').innerHTML = '';
                document.getElementById('class_id').disabled = true;
            }
        });
        /*
                document.getElementById('username').addEventListener('input', function(event) {
                    const inputField = event.target;
                    const invalidFeedback = inputField.nextElementSibling; // Target the invalid-feedback div

                    // Regular expression to allow only letters and spaces
                    const regex = /^[a-zA-Z\s]*$/;

                    // Remove invalid characters immediately
                    inputField.value = inputField.value.replace(/[^a-zA-Z\s]/g, '');

                    // Check if the current input matches the allowed pattern
                    if (!regex.test(inputField.value)) {
                        inputField.classList.add('is-invalid');
                        invalidFeedback.style.display = 'block'; // Show error message
                    } else {
                        inputField.classList.remove('is-invalid');
                        invalidFeedback.style.display = 'none'; // Hide error message
                    }
                });
                */
    </script>
@endsection
