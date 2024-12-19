{{-- @extends('layouts.admin')

@section('content') --}}
<div class="container">
    <h1>Assignment Details</h1>

    <div class="card">
        <div class="card-body">
            <h3>{{ $assignment->title }}</h3>

            <p><strong>Description:</strong> {!! nl2br(e($assignment->description)) !!}</p>

            <p><strong>Lesson:</strong> {{ $assignment->lesson->title ?? '' }}</p>
            <p><strong>School:</strong> {{ $assignment->school->name ?? '' }}</p>
            <p><strong>Teacher:</strong> {{ $assignment->teacher->username ?? '' }}</p>
            <p><strong>Start Date:</strong> {{ $assignment->start_date ?? '' }}</p>
            <p><strong>Due Date:</strong> {{ $assignment->due_date ?? '' }}</p>

            <p><strong>Marks:</strong> {{ $assignment->marks ?? '' }}</p>

            <p><strong>File:</strong>
                @if ($assignment->path_file)
                    <a href="{{ asset($assignment->path_file) }}" target="_blank">Download File</a>
                @else
                    No file uploaded
                @endif
            </p>

            <p><strong>Link:</strong>
                @if ($assignment->link)
                    <a href="{{ $assignment->link }}" target="_blank">{{ $assignment->link }}</a>
                @else
                    No link provided
                @endif
            </p>

            <p><strong>Assigned Students:</strong></p>
            <ul>
                @foreach ($assignment->students as $student)
                    <li>{{ $student->username }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <a href="{{ route('assignments.index') }}" class="btn btn-secondary mt-3">Back to Assignments</a>
</div>
{{-- @endsection --}}
