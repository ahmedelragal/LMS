@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">
                    <h1>Edit Unit</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('units.update', $unit->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" id="title"
                                value="{{ $unit->title }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="material_id" class="form-label">Theme</label>
                            <select name="material_id" class="form-control" id="material_id" required>
                                @foreach ($materials as $material)
                                    <option value="{{ $material->id }}"
                                        {{ $unit->material_id == $material->id ? 'selected' : '' }}>
                                        {{ $material->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" id="image" accept="image/*">
                            @if ($unit->image)
                                <p>Current Image:</p>
                                <img src="{{ asset( $unit->image) }}" alt="{{ $unit->title }}" width="100">
                            @endif
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1"
                                {{ $unit->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Unit</button>
                    </form>
                </div>
            </main>

             
        </div>
    </div>
@endsection
