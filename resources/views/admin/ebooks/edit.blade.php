@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h1>Edit Ebook</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('ebooks.update', $ebook->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" id="title"
                                value="{{ $ebook->title }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="author" class="form-label">Author</label>
                            <input type="text" name="author" class="form-control" id="author"
                                value="{{ $ebook->author }}">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="description">{{ $ebook->description }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="file_path" class="form-label">File</label>
                            <input type="file" name="file_path" class="form-control" id="file_path">
                            @if ($ebook->file_path)
                                <p>Current File: <a href="{{ asset('storage/' . $ebook->file_path) }}"
                                        target="_blank">View</a></p>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="lesson_id" class="form-label">Lesson</label>
                            <select name="lesson_id" id="lesson_id" class="form-control" required>
                                <option value="">Select Lesson</option>
                                @foreach ($lessons as $lesson)
                                    <option value="{{ $lesson->id }}"
                                        {{ $lesson->id == $ebook->lesson_id ? 'selected' : '' }}>
                                        {{ $lesson->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Ebook</button>
                    </form>

                </div>
            </main>

             
        </div>
    </div>
@endsection
