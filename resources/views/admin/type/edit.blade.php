@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h2>Edit Type</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('types.update', $types->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                    
    
                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <input type="text" name="name" id="type" value="{{ $types->name }}" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Edit Type</button>
                    </form>

                </div>
            </main>

             
        </div>
    </div>
@endsection
