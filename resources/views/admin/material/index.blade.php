@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h1>Theme</h1>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Wrap table in a scrollable container -->
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Grade</th>
                                    <th>Image</th>
                                    <th>Ebook info</th>
                                    <th>Ebook learning</th>
                                    <th>Ebook how to use</th>
                                    <th>Active</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materials as $material)
                                    <tr>
                                        <td>{{ $material->title }}</td>
                                        <td>{{ $material->stage->name }}</td>
                                        <td>
                                            @if ($material->image)
                                                <img src="{{ asset($material->image) }}" alt="{{ $material->title }}"
                                                    width="100">
                                            @else
                                                No Image
                                            @endif
                                        </td>

                                        <!-- Set fixed width and prevent wrapping -->
                                        <td style="white-space: nowrap; width: 150px;">
                                            <button class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#ebookModal" data-file="{{ asset($material->file_path) }}">
                                                File info
                                            </button>
                                        </td>

                                        <td style="white-space: nowrap; width: 150px;">
                                            <button class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#ebookModal" data-file="{{ asset($material->learning) }}">
                                                Learning
                                            </button>
                                        </td>

                                        <td style="white-space: nowrap; width: 150px;">
                                            <button class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#ebookModal" data-file="{{ asset($material->how_to_use) }}">
                                                How to use
                                            </button>
                                        </td>

                                        <td>{{ $material->is_active ? 'Active' : 'Inactive' }}</td>
                                        <td class="d-flex align-items-center gap-2">
                                            <a href="{{ route('material.edit', $material->id) }}"
                                                class="btn btn-info">Edit</a>
                                            <form action="{{ route('material.destroy', $material->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"  onclick="return confirm('Are you sure you want to delete this theme?');">Delete</button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>


                        </table>
                    </div>
                    <!-- End of scrollable table container -->

                </div>
            </main>

        </div>
    </div>

    {{-- Modal --}}
    <div class="modal fade" id="ebookModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="max-width: 90%; max-height: 90%; margin: auto;">
            <div class="modal-content" style="height: 90vh;">
                <div class="modal-header">
                    <h5 class="modal-title">Ebook</h5>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                <div class="position-relative modal-body" style="height: calc(100% - 60px);">
                    <embed src="" id="ebookEmbed" width="100%" height="100%" style="border: none;"></embed>
                    <img src="{{ asset('assets/img/watermark 2.png') }}"
                        class="position-absolute top-0 start-0 w-100 h-100" style="pointer-events: none; opacity: 0.5;">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_js')
    <script>
        $(document).ready(function() {
            // Handle the event when the modal is about to be shown
            $('#ebookModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var file = button.data('file'); // Extract the file path from data-file attribute
                var modal = $(this);
                var embed = modal.find('#ebookEmbed');

                // Set the src attribute of the embed to the eBook file path
                embed.attr('src', file);
            });

            // Clear the embed src when the modal is hidden to stop the loading
            $('#ebookModal').on('hide.bs.modal', function() {
                var embed = $(this).find('#ebookEmbed');
                embed.attr('src', '');
            });
        });
    </script>
@endsection
