@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">

                    <h1>Ebooks</h1>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <a href="{{ route('ebooks.create') }}" class="btn btn-primary mb-3">Add Ebook</a>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Lesson</th>
                                <th>File</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ebooks as $ebook)
                                <tr>
                                    <td>{{ $ebook->title }}</td>
                                    <td>{{ $ebook->author ?? 'N/A' }}</td>
                                    <td>{{ $ebook->lesson->title }}</td>
                                    <td>
                                        <a href="{{ route('ebooks.view', $ebook->id) }}" target="_blank" class="btn btn-success">View
                                            Ebook</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('ebooks.edit', $ebook->id) }}" class="btn btn-info">Edit</a>
                                        <form action="{{ route('ebooks.destroy', $ebook->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </main>

             
        </div>
    </div>
@endsection
