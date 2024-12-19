@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h2>Upload Images</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('images.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="images" class="form-label">Select Images</label>
                            <input type="file" name="images[]" id="images" class="form-control" multiple>
                        </div>

                        <button type="submit" class="btn btn-primary">Upload Images</button>
                    </form>

                </div>
            </main>

             
        </div>
    </div>
@endsection
