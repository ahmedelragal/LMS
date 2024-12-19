@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h1>Chapters</h1>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- <a href="{{ route('chapters.create') }}" class="btn btn-primary mb-3">Add Chapter</a> --}}


                    <div class="table-responsive" style="overflow-x: auto;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Unit</th>
                                    <th>Theme</th>
                                    <th>Grade</th>
                                    <th>Image</th>
                                    <th>Active</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($chapters as $chapter)
                                    <tr>
                                        <td>{{ $chapter->title }}</td>
                                        <td>{{ $chapter->unit->title }}</td>
                                        <td>{{ $chapter->material->title }}</td>
                                        <td>{{ $chapter->material->stage->name }}</td> <!-- Add stage name -->
                                        <td>
                                            @if ($chapter->image)
                                                <img src="{{ asset($chapter->image) }}" alt="{{ $chapter->title }}"
                                                    width="100">
                                            @else
                                                No Image
                                            @endif
                                        </td>
                                        <td>{{ $chapter->is_active ? 'Active' : 'Inactive' }}</td>
                                        <td class="d-flex align-items-center gap-2">
                                            <a href="{{ route('chapters.edit', $chapter->id) }}"
                                                class="btn btn-info">Edit</a>
                                            <form action="{{ route('chapters.destroy', $chapter->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"  onclick="return confirm('Are you sure you want to delete this chapter?');">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                {{ $chapters->appends(request()->input())->links('pagination::bootstrap-5') }}
            </main>


        </div>
    </div>
@endsection
