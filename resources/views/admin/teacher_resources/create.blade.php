@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">
                    <h1>Add Teacher Resource</h1>

                    <form action="{{ route('teacher_resources.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>


                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" name="image" class="form-control">
                                </div>

                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6">

                                <div class="mb-3">
                                    <label for="file_path" class="form-label">File</label>
                                    <input type="file" name="file_path" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select name="type" id="type" class="form-control" required>
                                    <option value="pdf">PDF</option>
                                    <option value="ebook">eBook</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="stage_id" class="form-label">Stage</label>
                                    <select name="stage_id" class="form-control" required>
                                        @foreach ($stages as $stage)
                                            <option value="{{ $stage->id }}">{{ $stage->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="school_id" class="form-label">School</label>
                                    <select name="school_id" class="form-control" required>
                                        @foreach ($schools as $school)
                                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>





                        <button type="submit" class="btn btn-success">Add Resource</button>
                    </form>
                </div>
            </main>


        </div>
    </div>
@endsection
