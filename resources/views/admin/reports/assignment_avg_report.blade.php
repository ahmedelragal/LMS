@extends('admin.layouts.layout')

@section('content')
<div class="wrapper">
    @include('admin.layouts.sidebar')

    <div class="main">
        @include('admin.layouts.navbar')

        <main class="content">
            <div class="container-fluid p-0">
                <h2>Assignment Average Degree Report</h2>

                @if (session('error'))
                <div class="alert alert-danger d-flex justify-content-between align-items-center" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>


                @endif

                <form id="filter-form" action="{{ route('admin.assignmentAvgReport') }}" method="GET" enctype="multipart/form-data" class="mb-4 flex" style="gap:10px; padding:10px">
                    <div class="mb-3">
                        <label for="teacher_id">Teacher</label>
                        <select name="teacher_id" id="teacher_select" class="form-control">
                            <option value="">All Teachers</option>
                            @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}"
                                {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->username }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="school_id">School</label>
                        <select name="school_id" id="school_id" class="form-control">
                            <option value="">All Schools</option>
                            @foreach ($schools as $school)
                            <option value="{{ $school->id }}"
                                {{ request('school_id') == $school->id ? 'selected' : '' }}>
                                {{ $school->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="container mt-3">
                <canvas id="groupedBarChart" width="400" height="200"></canvas>
            </div>
        </main>


    </div>
</div>
@endsection

@section('page_js')
<script>
    // Select the form and the select elements
    const filterForm = document.getElementById('filter-form');
    const selects = document.querySelectorAll('#filter-form select');

    // Add event listener to each select element
    selects.forEach(select => {
        select.addEventListener('change', () => {
            filterForm.submit(); // Submit the form when a select value changes
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@if (isset($chartData))
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartData = @json($chartData);
    const grades = chartData.map(item => item.grade);
    const datasets = [];

    chartData.forEach((gradeData, gradeIndex) => {
        gradeData.assignments.forEach((assignment, assignmentIndex) => {
            datasets.push({
                label: `${gradeData.grade} - ${assignment.name}`,
                data: chartData.map((_, index) =>
                    index === gradeIndex ? assignment.degree : null
                ),
                backgroundColor: `rgba(${50 + gradeIndex * 50}, ${100 + assignmentIndex * 40}, 200, 0.6)`,
                borderColor: `rgba(${50 + gradeIndex * 50}, ${100 + assignmentIndex * 40}, 200, 1)`,
                borderWidth: 1
            });
        });
    });

    const ctx = document.getElementById("groupedBarChart").getContext("2d");
    const groupedBarChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: grades,
            datasets: datasets
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        title: (tooltipItems) => tooltipItems[0].dataset.label.split(" - ")[1]
                    }
                }
            },
            scales: {
                x: {
                    stacked: false,
                    title: {
                        display: true,
                        text: "Grades"
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: "Average Assignment Degree"
                    }
                }
            }
        }
    });
</script>

@endif

@endsection