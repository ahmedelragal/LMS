@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">
                    <h1>Edit theme</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('material.update', $material->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" id="title"
                                value="{{ $material->title }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="stage_id" class="form-label">Grade</label>
                            <select name="stage_id" class="form-control" id="stage_id" required>
                                @foreach ($stages as $stage)
                                    <option value="{{ $stage->id }}"
                                        {{ $material->stage_id == $stage->id ? 'selected' : '' }}>{{ $stage->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" id="image" accept="image/*">
                            @if ($material->image)
                                <p>Current Image: <img class="my-3" src="{{ asset($material->image) }}" width="100">
                                </p>
                            @endif
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="file_path" class="form-label">Choose Info</label>
                                <select name="file_path" class="form-control" id="file_path">
                                    @foreach (\App\Models\Ebook::all() as $ebook)
                                        <option value="{{ $ebook->file_path }}"
                                            {{ str_replace(url('ebooks') . '/', '', $material->file_path) == $ebook->file_path ? 'selected' : '' }}>
                                            {{ $ebook->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('file_path')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="mb-3">
                                <label for="how_to_use" class="form-label">Choose how to use</label>
                                <select name="how_to_use" class="form-control" id="how_to_use">
                                    @foreach (\App\Models\Ebook::all() as $ebook)
                                        <option value="{{ $ebook->file_path }}"
                                            {{ str_replace(url('ebooks') . '/', '', $material->how_to_use) == $ebook->file_path ? 'selected' : '' }}>
                                            {{ $ebook->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('how_to_use')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="mb-3">
                                <label for="learning" class="form-label">Choose learning outcomes</label>
                                <select name="learning" class="form-control" id="learning">
                                    @foreach (\App\Models\Ebook::all() as $ebook)
                                        <option value="{{ $ebook->file_path }}"
                                            {{ str_replace(url('ebooks') . '/', '', $material->learning) == $ebook->file_path ? 'selected' : '' }}>
                                            {{ $ebook->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('learning')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1"
                                {{ $material->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>

                        <button type="submit" class="btn btn-primary">Update theme</button>
                    </form>
                </div>
            </main>


        </div>
    </div>
@endsection
