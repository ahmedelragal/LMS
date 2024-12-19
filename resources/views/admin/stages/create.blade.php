@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h1>Create Grade</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('stages.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Grade Name</label>
                            <input type="text" name="name" class="form-control" id="name"
                                value="{{ old('name') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Grade Image</label>
                            <input type="file" name="image" class="form-control" id="image" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary">Create Grade</button>
                    </form>

                </div>
            </main>

             
        </div>
    </div>
@endsection
