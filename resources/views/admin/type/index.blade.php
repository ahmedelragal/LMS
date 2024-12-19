@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">
                    <h1>Types</h1>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <a href="{{ route('types.create') }}" class="btn btn-primary mb-3">Add New Type</a>

                    <!-- Add scrollable wrapper for horizontal scroll -->
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($types as $type)
                                    <tr>
                                        <td>{{ $type->name }}</td>
                                        <td class="d-flex align-items-center gap-2">
                                            <a href="{{ route('types.edit', $type->id) }}" class="btn btn-info">Edit</a>

                                            <!-- Delete button -->
                                            <form action="{{ route('types.destroy', $type->id) }}" method="POST" >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this type?');">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- End of scrollable wrapper -->

                </div>
                {{ $types->links('pagination::bootstrap-5') }}
            </main>

        </div>
    </div>
@endsection
