@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h2>Edit Class</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('classes.update', $class->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name', $class->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Image (Optional)</label>
                            <input type="file" name="image" id="image" class="form-control">
                            @if ($class->image)
                                <div class="mt-2">
                                    <img src="{{ asset($class->image) }}" alt="Class Image" width="150">
                                    <p>Current Image</p>
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="school_id" class="form-label">School</label>
                            <select name="school_id" id="school_id" class="form-control" required>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}"
                                        {{ $class->school_id == $school->id ? 'selected' : '' }}>
                                        {{ $school->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="stage_id" class="form-label">Grade</label>
                            <select name="stage_id" id="stage_id" class="form-control" required>
                                @foreach ($stages as $stage)
                                    <option value="{{ $stage->id }}"
                                        {{ $class->stage_id == $stage->id ? 'selected' : '' }}>
                                        {{ $stage->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Class</button>
                    </form>

                </div>
            </main>

             
        </div>
    </div>
@endsection
