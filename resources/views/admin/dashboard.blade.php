@extends('admin.layouts.layout')

@section('content')
    <div class="wrapper">
        @include('admin.layouts.sidebar')

        <div class="main">
            @include('admin.layouts.navbar')

            <main class="content">
                <div class="container-fluid p-0">
                    <h1 class="h3 mb-3">Admin Dashboard</h1>

                    <div class="row">
                        <!-- Total Schools Card -->
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title text-white">Total Schools</h5>
                                    <h3 class="text-white">{{ $totalSchools }}</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Total Teachers Card -->
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title text-white">Total Teachers</h5>
                                    <h3 class="text-white">{{ $totalTeachers }}</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Total Students Card -->
                        <div class="col-md-4">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5 class="card-title text-white">Total Students</h5>
                                    <h3 class="text-white">{{ $totalStudents }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                   
                </div>
            </main>

             
        </div>
    </div>
@endsection
