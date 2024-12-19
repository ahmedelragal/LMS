@extends('admin.layouts.layout')

@section('content')
<div class="wrapper">
    @include('admin.layouts.sidebar')

    <div class="main">
        @include('admin.layouts.navbar')

        <main class="content">
            <div class="container-fluid p-0">

                <h2>Create Observer</h2>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('observers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>

                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                        <div class="invalid-feedback" style="display: none;">Username cannot contain numbers.</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        <div class="invalid-feedback" style="display: none;">Username cannot contain numbers.</div>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="confirm_password" class="form-control" required>
                        <div class="invalid-feedback" style="display: none;">Invalid Password</div>
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select name="gender" id="gender" class="form-control" required>
                            <option selected disabled hidden></option>
                            <option value="boy">Boy</option>
                            <option value="girl">Girl</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Create Observer</button>
                </form>

            </div>
        </main>


    </div>
</div>
@endsection
@section('page_js')
<script>
    document.getElementById('school_id').addEventListener('change', function() {
        let schoolId = this.value;
        let stageSelect = document.getElementById('stage_id');
        let classSelect = document.getElementById('class_id');

        // Reset both the stage and class dropdowns
        stageSelect.innerHTML = '<option value="" selected disabled hidden>Select Stage</option>';
        classSelect.innerHTML = '<option value="" selected disabled hidden>Select Class</option>';

        if (schoolId) {
            fetch(`{{ route('admin.schools.stages', ':school') }}`.replace(':school', schoolId))
                .then(response => response.json())
                .then(data => {
                    data.forEach(stage => {
                        stageSelect.innerHTML +=
                            `<option value="${stage.id}">${stage.name}</option>`;
                    });
                });
        }
    });

    document.getElementById('stage_id').addEventListener('change', function() {
        let schoolId = document.getElementById('school_id').value;
        let stageId = this.value;
        let classSelect = document.getElementById('class_id');

        classSelect.innerHTML = '<option value="" selected disabled hidden>Select Class</option>';

        if (schoolId && stageId) {
            fetch(`{{ route('admin.schools.stages.classes', [':school', ':stage']) }}`
                    .replace(':school', schoolId)
                    .replace(':stage', stageId))
                .then(response => response.json())
                .then(data => {
                    data.forEach(cls => {
                        classSelect.innerHTML += `<option value="${cls.id}">${cls.name}</option>`;
                    });
                });
        }
    });


    document.getElementById('username').addEventListener('input', function(event) {
        const inputField = event.target;
        const invalidFeedback = inputField.nextElementSibling;

        const regex = /^[a-zA-Z][a-zA-Z0-9\s]*$/;

        if (!regex.test(inputField.value)) {
            inputField.classList.add('is-invalid');
            invalidFeedback.style.display = 'block';
        } else {
            inputField.classList.remove('is-invalid');
            invalidFeedback.style.display = 'none';
        }
    });
</script>
@endsection