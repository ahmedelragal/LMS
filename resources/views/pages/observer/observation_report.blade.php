@extends('layouts.app')

@section('title')
Observer Dashboard
@endsection

@php
$menuItems = [
['label' => 'Observations', 'icon' => 'fi fi-rr-table-rows', 'route' => route('observer.dashboard')],
['label' => 'Observations Report', 'icon' => 'fi fi-rr-table-rows', 'route' => route('observer.report')],
];
@endphp

@section('sidebar')
@include('components.sidebar', ['menuItems' => $menuItems])
@endsection

@section('content')
<div class="p-3 text-[#667085] my-8" style="padding:20px">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Observations Report</h1>
        <form id="filter-form" action="{{ route('observer.report') }}" method="GET" enctype="multipart/form-data" class="mb-4 flex" style="gap:10px; padding:10px">
            <div>
                <select name="teacher_id" id="teacher_select" class="w-full p-2 border border-gray-300 rounded">
                    <option value="">All Teachers</option>
                    @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}"
                        {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->username }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="stage_id" id="stage_select" class="w-full p-2 border border-gray-300 rounded">
                    <option value="">All Stages</option>
                    @foreach ($stages as $stage)
                    <option value="{{ $stage->id }}"
                        {{ request('stage_id') == $stage->id ? 'selected' : '' }}>
                        {{ $stage->name }}
                    </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3 text-green-700" onclick="this.parentElement.remove();">
            <svg class="fill-current h-6 w-6 text-green-700" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Close</title>
                <path d="M14.348 5.652a1 1 0 10-1.414-1.414L10 7.586 7.066 4.652a1 1 0 10-1.414 1.414L8.586 10l-2.93 2.934a1 1 0 101.414 1.414L10 12.414l2.934 2.934a1 1 0 101.414-1.414L11.414 10l2.934-2.934z" />
            </svg>
        </button>
    </div>
    @endif
    @if (session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3 text-red-700" onclick="this.parentElement.remove();">
            <svg class="fill-current h-6 w-6 text-red-700" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <title>Close</title>
                <path d="M14.348 5.652a1 1 0 10-1.414-1.414L10 7.586 7.066 4.652a1 1 0 10-1.414 1.414L8.586 10l-2.93 2.934a1 1 0 101.414 1.414L10 12.414l2.934 2.934a1 1 0 101.414-1.414L11.414 10l2.934-2.934z" />
            </svg>
        </button>
    </div>
    @endif
    <div class="overflow-x-auto">
        <div class="mb-4 flex" style="gap:10px; padding:10px">
            <div class="questions mb-3" style="max-width: 65%;">
                @foreach ($data as $header)
                <h1 class="text-lg font-semibold text-[#667085] mb-4" style="font-size:24px">{{$header['name']}}</h1>
                @foreach ($header['questions'] as $question)
                <h3 class="text-base font-medium text-gray-700 mb-2" style="font-size:18px">- {{$question['name']}}</h3>

                <div class="rating-bar" style="margin-bottom: 10px;">
                    <div style="position: relative; background-color: #e5e7eb; border-radius: 8px; height: 20px; width: 100%;">
                        <div style="background-color: #667085; height: 100%; border-radius: 8px; width: {{ ($question['avg_rating'] / $question['max_rating']) * 100 }}%;"></div>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">Average Rating: {{ $question['avg_rating'] }} / {{ $question['max_rating'] }}</p>
                </div>
                @endforeach
                <br>
                @endforeach
            </div>

        </div>
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
@endsection