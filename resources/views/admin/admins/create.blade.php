@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h1>Add School </h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admins.store') }}" method="POST">
                        @csrf


                        <div class="mb-3">
                            <label for="school_name" class="form-label">School Name</label>
                            <input type="text" name="name" class="form-control" id="school_name"
                                value="{{ old('school_name') }}" required>
                        </div>



                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" id="address"
                                value="{{ old('address') }}">
                        </div>

                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" name="city" class="form-control" id="city"
                                value="{{ old('city') }}">
                        </div>


                        <!-- Grade Selection -->


                        <div class="mb-3">
                            <label for="stage_ids" class="form-label">Grades</label>
                            <select name="stage_id[]" id="stage_id" class="form-control" multiple required>
                                @foreach ($stages as $stage)
                                    <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                                @endforeach
                            </select>
                        </div>





                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select name="type_id" id="type" class="form-control" required>
                                <option value="" selected disabled>Select type</option>

                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-3">
                            <h2>Classes</h2>
                            <div id="class-container">
                                <!-- Dynamic class fields will appear here -->
                            </div>
                            <button type="button" class="btn btn-secondary" id="add-class-btn">Add Class</button>
                        </div>



                        <button type="submit" class="btn btn-primary mt-5">Add School</button>
                    </form>


                </div>
            </main>

             
        </div>
    </div>
@endsection

@section('page_js')
    <script>
        $(document).ready(function() {
    $('#stage_id').select2({
        placeholder: "Select Grades",
        allowClear: true
    });

    const addClassBtn = document.getElementById('add-class-btn');
    const classContainer = document.getElementById('class-container');
    let classCount = 0;

    function addClassField(stages) {
        classCount++;
        const classGroup = document.createElement('div');
        classGroup.classList.add('class-group', 'mb-3');
        classGroup.setAttribute('id', `class-group-${classCount}`);

        let stageOptions = '';
        stages.forEach(stage => {
            stageOptions += `<option value="${stage.id}">${stage.text}</option>`;
        });

        classGroup.innerHTML = `
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="class_name_${classCount}" class="form-label">Class Name</label>
                        <input type="text" name="classes[${classCount}][name]" class="form-control" id="class_name_${classCount}" placeholder="Enter class name" required>
                    </div>
                    <div class="mb-3">
                        <label for="class_stage_${classCount}" class="form-label">Grade</label>
                        <select name="classes[${classCount}][stage_id]" id="class_stage_${classCount}" class="form-control" required>
                            ${stageOptions}
                        </select>
                    </div>
                    <button type="button" class="btn btn-danger remove-class-btn" data-class-id="${classCount}">Remove Class</button>
                </div>
            </div>
        `;

        classContainer.appendChild(classGroup);

        classGroup.querySelector('.remove-class-btn').addEventListener('click', function() {
            const classId = this.getAttribute('data-class-id');
            document.getElementById(`class-group-${classId}`).remove();
        });
    }

    $('#stage_id').on('change', function() {
        const selectedStages = $('#stage_id').select2('data'); // Get selected stages
        if (selectedStages.length > 0) {
            addClassBtn.disabled = false;
        } else {
            addClassBtn.disabled = true;
        }

        classContainer.innerHTML = '';
    });

    addClassBtn.addEventListener('click', function() {
        const selectedStages = $('#stage_id').select2('data');
        if (selectedStages.length > 0) {
            const formattedStages = selectedStages.map(stage => ({
                id: stage.id,
                text: stage.text
            }));
            addClassField(formattedStages);
        }
    });
});



        document.getElementById('city').addEventListener('input', function (event) {
            this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
        });
    </script>
@endsection
