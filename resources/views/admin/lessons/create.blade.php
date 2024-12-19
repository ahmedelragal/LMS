@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">
                    <h1>Create Lesson</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('lessons.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Lesson Title</label>
                            <input type="text" name="title" class="form-control" id="title"
                                value="{{ old('title') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="chapter_id" class="form-label">Select Chapter</label>
                            <select name="chapter_id" id="chapter_id" class="form-control" required>
                                @foreach ($chapters as $chapter)
                                    <option value="{{ $chapter->id }}"> {{ $chapter->material->stage->name }} / {{ $chapter->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Lesson Image</label>
                            <input type="file" name="image" class="form-control" id="image" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="file_path" class="form-label">Choose Ebook </label>
                             <select name="file_path" class="form-control" id="file_path">
                                                @foreach(\App\Models\Ebook::all() as $ebook)
                                                <option value="{{$ebook->file_path}}">
                                                    {{ $ebook->title }}
                                                    
                                                </option>
                                                @endforeach
                                            </select>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1">
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>

                        <button type="submit" class="btn btn-primary">Create Lesson</button>
                    </form>
                </div>
            </main>

             
        </div>
    </div>
@endsection
