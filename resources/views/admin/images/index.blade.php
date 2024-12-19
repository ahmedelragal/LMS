@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h2>Uploaded Images</h2>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <a href="{{ route('images.create') }}" class="btn btn-primary mb-3">Upload New Images</a>

                    <div class="row">
                        @foreach ($images as $key => $image)
                            <div class="col-md-4 col-lg-3">
                                <div class="card mb-4 " style="height: 350px;">
                                    <div style="height: 250px; overflow: hidden;">
                                        <img src="{{ asset($image->path) }}" alt="Image"
                                            class="card-img-top"
                                            style="height: 100%; width: 100%; object-fit: cover; cursor: pointer;"
                                            data-bs-toggle="modal" data-bs-target="#imageModal"
                                            data-bs-slide-to="{{ $key }}">
                                    </div>
                                    <div class="card-body d-flex flex-column justify-content-between">
                                        <h5 class="card-title text-truncate">{{ $image->title ?? 'Image ' . $image->id }}
                                        </h5>
                                        <form action="{{ route('images.destroy', $image->id) }}" method="POST"
                                            class="mt-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger w-100"  onclick="return confirm('Are you sure you want to delete this image?');">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="imageModalLabel">Image Viewer</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            @foreach ($images as $key => $image)
                                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                    <img src="{{ asset($image->path) }}" class="d-block w-100"
                                                        alt="Image" style="height: 500px; object-fit: contain;">
                                                </div>
                                            @endforeach
                                        </div>
                                        <button class="carousel-control-prev" type="button"
                                            data-bs-target="#carouselExample" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"
                                                style="filter: invert(100%);"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button"
                                            data-bs-target="#carouselExample" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"
                                                style="filter: invert(100%);"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>

             
        </div>
    </div>
@endsection

@section('page_js')
    <script>
        document.querySelectorAll('.card-img-top').forEach((image, index) => {
            image.addEventListener('click', function() {
                const slideIndex = image.getAttribute('data-bs-slide-to');
                const carousel = document.querySelector('#carouselExample');
                const bootstrapCarousel = new bootstrap.Carousel(carousel);
                bootstrapCarousel.to(slideIndex);
            });
        });
    </script>
@endsection
