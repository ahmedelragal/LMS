@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">
                    <h1>Edit Chapter</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('chapters.update', $chapter->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Chapter Title</label>
                            <input type="text" name="title" class="form-control" id="title"
                                value="{{ $chapter->title }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="unit_id" class="form-label">Select Unit</label>
                            <select name="unit_id" id="unit_id" class="form-control" required>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}"
                                        {{ $chapter->unit_id == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="material_id" class="form-label">Select Theme</label>
                            <select name="material_id" id="material_id" class="form-control" required>
                                @foreach ($materials as $material)
                                    <option value="{{ $material->id }}"
                                        {{ $chapter->material_id == $material->id ? 'selected' : '' }}>
                                        {{ $material->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Chapter Image</label>
                            <input type="file" name="image" class="form-control" id="image" accept="image/*">
                            @if ($chapter->image)
                                <p>Current Image: <img class="my-3" src="{{ asset( $chapter->image) }}"
                                        alt="{{ $chapter->title }}" width="100"></p>
                            @endif
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1"
                                {{ $chapter->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Chapter</button>
                    </form>
                </div>
            </main>

             
        </div>
    </div>
@endsection
