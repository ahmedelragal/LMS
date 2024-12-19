@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <main class="content">
                <div class="container-fluid p-0">
                    <h1>Add Material</h1>

                    <!-- Material Form -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3>Create Theme</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('material.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="stage_id" value="{{ $stage->id }}">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Theme Title</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                required>
                                            @error('title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="material_image" class="form-label">Upload New Image</label>
                                            <input type="file" name="image" class="form-control image-input"
                                                id="material_image" accept="image/*">
                                            @if ($errors->material->has('image'))
                                                <div class="text-danger">{{ $errors->material->first('image') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <button type="button" class="btn btn-secondary chooseFromLibraryButton"
                                            data-target="existing_image_material" data-preview="material_preview">
                                            Choose from Library
                                        </button>
                                        <input type="hidden" name="existing_image" id="existing_image_material"
                                            value="">
                                        @error('existing_image')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div id="material_preview-container" style="display: none;">
                                        <h5>Selected Image Preview:</h5>
                                        <img id="material_preview" src="" alt="Selected Image"
                                            style="max-width: 200px; border-radius: 8px; box-shadow: 0px 0px 5px #ccc;">
                                    </div>

                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label for="file_path" class="form-label">Choose Info </label>
                                            <!--<input type="file" name="file_path" class="form-control" id="file_path"-->
                                            <!--    required>-->
                                            <select name="file_path" class="form-control" id="file_path">
                                                @foreach (\App\Models\Ebook::all() as $ebook)
                                                    <option value="{{ $ebook->file_path }}">
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
                                            <label for="how_to_use" class="form-label">Choose how to use </label>
                                            <!--<input type="file" name="how_to_use" class="form-control" id="how_to_use"-->
                                            <!--    required>-->
                                            <select name="how_to_use" class="form-control" id="how_to_use">
                                                @foreach (\App\Models\Ebook::all() as $ebook)
                                                    <option value="{{ $ebook->file_path }}">
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
                                            <label for="learning" class="form-label">Choose learning outcomes </label>
                                            <!--<input type="file" name="learning" class="form-control" id="learning"-->
                                            <!--    required>-->
                                            <select name="learning" class="form-control" id="learning">
                                                @foreach (\App\Models\Ebook::all() as $ebook)
                                                    <option value="{{ $ebook->file_path }}">
                                                        {{ $ebook->title }}

                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('learning')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Active </label>
                                    <input type="checkbox" id="is_active" name="is_active" value="1">
                                    @error('is_active')
                                        <div class="text-danger">{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Create Theme</button>
                            </form>
                        </div>
                    </div>

                    <!-- Unit Form -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3>Create Unit</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('units.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="unit_title" class="form-label">Unit Title</label>
                                            <input type="text" class="form-control" id="unit_title" name="title"
                                                required>
                                            @error('title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="material_id" class="form-label">Select Theme</label>
                                            <select class="form-control" id="material_id" name="material_id" required>
                                                <option value="">-- Select Theme --</option>
                                                @foreach ($materials as $material)
                                                    <option value="{{ $material->id }}">{{ $material->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="unit_image" class="form-label">Upload New Image</label>
                                            <input type="file" name="image" class="form-control image-input"
                                                id="unit_image" accept="image/*">
                                                @if ($errors->unit->has('image'))
                                                <div class="text-danger">{{ $errors->unit->first('image') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <button type="button" class="btn btn-secondary chooseFromLibraryButton"
                                            data-target="existing_image_unit" data-preview="unit_preview">
                                            Choose from Library
                                        </button>
                                        <input type="hidden" name="existing_image" id="existing_image_unit"
                                            value="">
                                    </div>

                                    <div class="mb-3" id="unit_preview-container" style="display: none;">
                                        <h5>Selected Image Preview:</h5>
                                        <img id="unit_preview" src="" alt="Selected Image"
                                            style="max-width: 200px; border-radius: 8px; box-shadow: 0px 0px 5px #ccc;">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Active </label>
                                    <input type="checkbox" id="is_active" name="is_active" value="1">
                                    @error('is_active')
                                        <div class="text-danger">{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Create Unit</button>
                            </form>
                        </div>
                    </div>



                    <!-- Chapter Form -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3>Create Chapter</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('chapters.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="chapter_title" class="form-label">Chapter Title</label>
                                            <input type="text" class="form-control" id="chapter_title" name="title"
                                                required>
                                            @error('title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="material_id" class="form-label">Select Theme</label>
                                            <select class="form-control" id="material_id" name="material_id" required>
                                                <option value="">-- Select Theme --</option>
                                                @foreach ($materials as $material)
                                                    <option value="{{ $material->id }}">{{ $material->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="unit_id" class="form-label">Select Unit</label>
                                            <select class="form-control" id="unit_id" name="unit_id" required>
                                                <option value="">-- Select Unit --</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}">{{$unit->material->title}} / {{$unit->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="chapter_image" class="form-label">Upload New Image</label>
                                            <input type="file" name="image" class="form-control image-input"
                                                id="chapter_image" accept="image/*">
                                            @if ($errors->chapter->has('image'))
                                                <div class="text-danger">{{ $errors->chapter->first('image') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <button type="button" class="btn btn-secondary chooseFromLibraryButton"
                                            data-target="existing_image_chapter" data-preview="chapter_preview">
                                            Choose from Library
                                        </button>
                                        <input type="hidden" name="existing_image" id="existing_image_chapter"
                                            value="">
                                    </div>

                                    <div class="mb-3" id="chapter_preview-container" style="display: none;">
                                        <h5>Selected Image Preview:</h5>
                                        <img id="chapter_preview" src="" alt="Selected Image"
                                            style="max-width: 200px; border-radius: 8px; box-shadow: 0px 0px 5px #ccc;">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Create Chapter</button>
                            </form>
                        </div>
                    </div>

                </div>
            </main>


        </div>
    </div>

    <!-- Image Library Modal -->
    <div class="modal fade" id="imageLibraryModal" tabindex="-1" aria-labelledby="imageLibraryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageLibraryModalLabel">Choose an Image from Library</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @foreach ($images as $image)
                            <div class="col-md-3 mb-3">
                                <div class="card image-option" style="cursor: pointer;" data-path="{{ $image->path }}">
                                    <img src="{{ asset($image->path) }}" alt="Image"
                                        class="card-img-top img-thumbnail selectable-image"
                                        style="width: 100%; height: 150px; object-fit: cover;">
                                    <div class="card-body text-center">
                                        <button class="btn btn-sm btn-primary select-image-button"
                                            type="button">Select</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Open Image Library Modal
            document.querySelectorAll('.chooseFromLibraryButton').forEach(button => {
                button.addEventListener('click', function() {
                    const targetInputId = this.dataset.target;
                    const previewId = this.dataset.preview;
                    const modal = new bootstrap.Modal(document.getElementById(
                        'imageLibraryModal'), {
                        keyboard: false
                    });
                    document.getElementById('imageLibraryModal').dataset.targetInput =
                        targetInputId;
                    document.getElementById('imageLibraryModal').dataset.previewId = previewId;
                    modal.show();
                });
            });

            // Select Image from Library
            document.querySelectorAll('.select-image-button').forEach(button => {
                button.addEventListener('click', function() {
                    const imageCard = this.closest('.image-option');
                    const imagePath = imageCard.getAttribute('data-path');
                    const modal = document.getElementById('imageLibraryModal');
                    const targetInputId = modal.dataset.targetInput;
                    const previewId = modal.dataset.previewId;

                    // Set the selected image path
                    if (targetInputId && previewId) {
                        const hiddenInput = document.getElementById(targetInputId);
                        const previewImage = document.getElementById(previewId);
                        const previewContainer = document.getElementById(previewId + '-container');

                        hiddenInput.value = imagePath;
                        if (previewImage && previewContainer) {
                            previewImage.src = `{{ asset('/') }}${imagePath}`;
                            previewContainer.style.display = 'block';
                        }

                        // Close the modal
                        const modalInstance = bootstrap.Modal.getInstance(modal);
                        modalInstance.hide();
                    }
                });
            });

            // Update Preview when New Image is Uploaded
            document.querySelectorAll('.image-input').forEach(fileInput => {
                fileInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        const previewId = this.id.replace('image', 'preview');
                        const previewContainer = document.getElementById(previewId + '-container');
                        const previewImage = document.getElementById(previewId);

                        reader.onload = function(e) {
                            if (previewImage && previewContainer) {
                                previewImage.src = e.target.result;
                                previewContainer.style.display = 'block';
                            }
                        };
                        reader.readAsDataURL(this.files[0]);

                        // Clear the hidden input since a new image is selected
                        const hiddenInputId = this.id.replace('image', 'existing_image');
                        const hiddenInput = document.getElementById(hiddenInputId);
                        if (hiddenInput) {
                            hiddenInput.value = '';
                        }
                    }
                });
            });
        });
    </script>
@endsection
