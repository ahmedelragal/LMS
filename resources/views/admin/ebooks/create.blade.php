@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h1>Add Ebook</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('ebooks.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" id="title"
                                value="{{ old('title') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="author" class="form-label">Author</label>
                            <input type="text" name="author" class="form-control" id="author"
                                value="{{ old('author') }}">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="description">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="file_path" class="form-label">Upload Ebook </label>
                            <input type="file" name="file_path" class="form-control" id="file_path" required>
                        </div>

                        <div class="mb-3">
                            <label for="lesson_id" class="form-label">Lesson</label>
                            <select name="lesson_id" id="lesson_id" class="form-control" required>
                                <option value="">Select Lesson</option>
                                @foreach ($lessons as $lesson)
                                    <option value="{{ $lesson->id }}">{{ $lesson->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Add Ebook</button>
                    </form>

                </div>
            </main>

             
        </div>
    </div>
@endsection
