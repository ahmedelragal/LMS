@extends('admin.layouts.layout')

@section('content')
<div class="container">
    <h1>Assignments</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('assignments.create') }}" class="btn btn-primary mb-3">Add Assignment</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>School</th>
                <th>Teacher</th>
                <th>Start Date</th>
                <th>Due Date</th>
                <th>Lesson</th>
                <th>Marks</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($assignments as $assignment)
                <tr>
                    <td>{{ $assignment->title }}</td>
                    <td>{!! $assignment->description !!}</td>
                    <td>{{ $assignment->school->name }}</td>
                    <td>{{ $assignment->teacher->username }}</td> 
                    <td>{{ $assignment->start_date }}</td>
                    <td>{{ $assignment->due_date }}</td>
                    <td>{{ $assignment->lesson->title }}</td>
                    <td>{{ $assignment->marks }}</td>
                    <td>{{ $assignment->is_active ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <a href="{{ route('assignments.show', $assignment->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('assignments.edit', $assignment->id) }}" class="btn btn-info">Edit</a>
                        <form action="{{ route('assignments.destroy', $assignment->id) }}" method="POST"
                            style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"  onclick="return confirm('Are you sure you want to delete this assignment?');">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
