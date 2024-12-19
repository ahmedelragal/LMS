@extends('admin.layouts.layout')

@section('content')
<div class="wrapper">
    @include('admin.layouts.sidebar')

    <div class="main">
        @include('admin.layouts.navbar')

        <main class="content">
            <div class="container-fluid p-0">
                <h1>Observers</h1>

                @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <a href="{{ route('observers.create') }}" class="btn btn-primary mb-3">Add Observer</a>



                <div class="table-responsive" style="overflow-x: auto;">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Gender</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($observers as $observer)
                            <tr>

                                <td>{{ $observer->name ?? '' }}</td>
                                <td>{{ $observer->username ?? '' }}</td>
                                <td>{{ $observer->gender ?? '' }}</td>
                                <td class="d-flex align-items-center gap-2">
                                    <a href="{{ route('observers.edit', $observer->id) }}"
                                        class="btn btn-info">Edit</a>

                                    <!-- Delete button -->
                                    <form action="{{ route('observers.destroy', $observer->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this Observer?');">
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
            {{ $observers->appends(request()->input())->links('pagination::bootstrap-5') }}

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