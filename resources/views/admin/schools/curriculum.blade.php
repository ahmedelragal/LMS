@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h1>Add Curriculum to {{ $school->name }}</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('school.curriculum.store', $school->id) }}" method="POST">
                        @csrf

                        <!-- Stage Selection -->
                        <div class="mb-3">
                            <label for="stage_id" class="form-label">Select Stage</label>
                            <select name="stage_id" id="stage_id" class="form-control" required>
                                <option value="">-- Select Stage --</option>
                                @foreach ($stages as $stage)
                                    <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- @dd($stages)  --}}
                        <!-- Material Selection (Multiple) -->
                        <div class="mb-3">
                            <label for="material_id" class="form-label">Select Materials</label>
                            <select name="material_id[]" id="material_id" class="form-control" multiple required disabled>
                                <option value="">-- Select Material --</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Assign Curriculum</button>
                    </form>

                </div>
            </main>

        </div>
    </div>
@endsection

@section('page_js')
    <!-- Include Select2 JS for better multi-select -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#material_id').select2({
                placeholder: "Select Materials",
                allowClear: true
            });
        });

        document.getElementById('stage_id').addEventListener('change', function() {
            let stageId = this.value;
            if (stageId) {
                const url = `{{ url('/api/stages/:stageId/materials') }}`.replace(':stageId', stageId);

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        let materialSelect = document.getElementById('material_id');
                        materialSelect.innerHTML = '';
                        data.forEach(material => {
                            materialSelect.innerHTML +=
                                `<option value="${material.id}">${material.title}</option>`;
                        });
                        materialSelect.disabled = false;
                    });
            } else {
                document.getElementById('material_id').disabled = true;
                document.getElementById('material_id').innerHTML =
                    '<option value="">-- Select Material --</option>';
            }
        });
    </script>
@endsection
