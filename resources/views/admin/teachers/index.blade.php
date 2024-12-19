@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">
                    <h1>Teachers</h1>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Button to create a new teacher -->
                    <a href="{{ route('teachers.create') }}" class="btn btn-primary mb-3">Add New Teacher</a>

                    <!-- Add Button to Generate New Teachers -->
                    <button type="button" class="btn btn-secondary mb-3" data-bs-toggle="modal"
                        data-bs-target="#generateTeachersModal">
                        Generate New Teachers
                    </button>

                    <!-- Modal for Generating Teachers -->
                    <div class="modal fade" id="generateTeachersModal" tabindex="-1"
                        aria-labelledby="generateTeachersModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('teachers.generate') }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="generateTeachersModalLabel">Generate New Teachers</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="number_of_teachers" class="form-label">Number of Teachers to
                                                Generate</label>

                                            <input type="text" name="number_of_teachers" class="form-control"
                                                id="number_of_teachers" required oninput="filterNumericInput(event)">
                                        </div>
                                        <div class="mb-3">
                                            <label for="school_id" class="form-label">Select School</label>
                                            <select name="school_id" class="form-control" id="school_id" required>
                                                <option value="">--Select School--</option>
                                                @foreach ($schools as $school)
                                                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Generate Teachers</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <form id="filterForm" action="{{ route('teachers.index') }}" method="GET"
                        class="d-flex justify-content-evenly mb-3">
                        <select name="school" id="school" class="form-select w-25">
                            <option disabled selected hidden>Filter By School</option>
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}"
                                    {{ request('school') == $school->id ? 'selected' : '' }}>
                                    {{ $school->name }}
                                </option>
                            @endforeach
                        </select>
                        <a class="btn btn-secondary" href="{{ route('teachers.index') }}">Clear</a>
                    </form>

                    <!-- Add scrollable wrapper for horizontal scroll -->
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Profile image</th>
                                    <th>Username</th>
                                    <th>Gender</th>
                                    <th>School</th>
                                    <th>Plain Password</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($teachers as $teacher)
                                    <tr>
                                        <td>
                                            @if ($teacher->image)
                                                <img src="{{ asset($teacher->image) }}" alt="Teacher Image" width="50"
                                                    height="50" class="rounded-circle">
                                            @else
                                                <img src="https://w7.pngwing.com/pngs/184/113/png-transparent-user-profile-computer-icons-profile-heroes-black-silhouette-thumbnail.png"
                                                    alt="Teacher Image" width="50" height="50"
                                                    class="rounded-circle">
                                            @endif
                                        </td>
                                        <td>{{ $teacher->username }}</td>
                                        <td>{{ ucfirst($teacher->gender) }}</td>
                                        <td>{{ $teacher->school->name }}</td>
                                        <td>{{ $teacher->plain_password }}</td>
                                        <td class="d-flex align-items-center gap-2">
                                            <a href="{{ route('teachers.edit', $teacher->id) }}"
                                                class="btn btn-info">Edit</a>

                                            <!-- Delete button -->
                                            <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this teacher?');">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                {{-- {{ $teachers->links('pagination::bootstrap-5') }} --}}
                {{ $teachers->appends(request()->input())->links('pagination::bootstrap-5') }}

            </main>

        </div>
    </div>
@endsection

@section('page_js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#school').change(function() {
                $('#filterForm').submit();
            });
        });

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
