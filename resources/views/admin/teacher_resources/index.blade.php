@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')
            <main class="content">

                <div class="container-fluid p-0">
                    <h1>Teacher Resources</h1>

                    <a href="{{ route('teacher_resources.create') }}" class="btn btn-primary mb-3">Add Resource</a>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Image</th>
                                <th>File</th>
                                <th>Type</th>

                                <th>Stage</th>
                                <th>School</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($resources as $resource)
                                <tr>
                                    <td>{{ $resource->name }}</td>
                                    <td>
                                        @if ($resource->image)
                                            <img src="{{ asset($resource->image) }}" width="100">
                                        @else
                                            No Image
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ asset( $resource->file_path) }}" target="_blank">View
                                            File</a>
                                    </td>
                                    <td>{{ ucfirst($resource->type) }}</td>

                                    <td>{{ $resource->stage->name }}</td>
                                    <td>{{ $resource->school->name }}</td>
                                    <td>
                                        <form action="{{ route('teacher_resources.destroy', $resource->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"  onclick="return confirm('Are you sure you want to delete this resource?');">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </main>

        </div>
    </div>
@endsection
