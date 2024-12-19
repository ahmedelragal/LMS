@extends('admin.layouts.layout')

@section('content')
<div class="wrapper">
    @include('admin.layouts.sidebar')

    <div class="main">
        @include('admin.layouts.navbar')

        <main class="content">
            <div class="container-fluid p-0">
                <h1>Students</h1>

                @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <a href="{{ route('students.create') }}" class="btn btn-primary mb-3">Add Student</a>

                <form id="filterForm" action="{{ route('students.index') }}" method="GET"
                    class="d-flex justify-content-evenly mb-3">
                    <select name="school" id="school" class="form-select w-25">
                        <option disabled selected hidden>Filter By School</option>
                        @foreach ($schools as $school)
                        <option value="{{ $school->id }}"
                            {{ request('school') == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                        @endforeach
                    </select>
                    <select name="class" id="class" class="form-select w-25">
                        <option disabled selected hidden>Filter By Class</option>
                        @foreach ($classes as $class)
                        <option value="{{ $class->id }}" {{ request('class') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                        @endforeach
                    </select>
                    <a class="btn btn-secondary" href="{{ route('students.index') }}">Clear</a>
                </form>

                <div class="table-responsive" style="overflow-x: auto;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Gender</th>
                                <th>School</th>
                                <th>Stage</th>
                                <th>Class</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                            <tr>
                                <td>
                                    @if ($student->image)
                                    <img src="{{ asset($student->image) }}" alt="Student Image" width="50"
                                        height="50" class="rounded-circle">
                                    @else
                                    <img src="https://w7.pngwing.com/pngs/184/113/png-transparent-user-profile-computer-icons-profile-heroes-black-silhouette-thumbnail.png"
                                        alt="Teacher Image" width="50" height="50"
                                        class="rounded-circle">
                                    @endif

                                </td>
                                <td>{{ $student->username ?? '' }}</td>
                                <td>{{ $student->plain_password }}</td>
                                <td>{{ ucfirst($student->gender) }}</td>
                                <td>{{ $student->school->name ?? '' }}</td>
                                <td>{{ $student->stage->name ?? '' }}</td>
                                <td>{{ $student->classes->name ?? '' }}</td>
                                <td class="d-flex align-items-center gap-2">
                                    <a href="{{ route('students.edit', $student->id) }}"
                                        class="btn btn-info">Edit</a>

                                    <!-- Delete button -->
                                    <form action="{{ route('students.destroy', $student->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this student?');">
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
            {{-- {{ $students->links('pagination::bootstrap-5') }} --}}
            {{ $students->appends(request()->input())->links('pagination::bootstrap-5') }}

        </main>

    </div>
</div>
@endsection

@section('page_js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#school, #class').change(function() {
            $('#filterForm').submit();
        });
    });

    $('#clearFilters').click(function(e) {
        e.preventDefault();
        $('#school').val('').prop('selected', true);
        $('#class').val('').prop('selected', true);
        $('#filterForm').submit();
    });
</script>
@endsection