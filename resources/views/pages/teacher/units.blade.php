@extends('layouts.app')

@section('title')
    Units for {{ $material->title }}
@endsection

@php
    $menuItems = [
        ['label' => 'Dashboard', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.dashboard')],
        ['label' => 'Resources', 'icon' => 'fi fi-rr-table-rows', 'route' => route('teacher.resources.index')],
    ];
@endphp

@section('sidebar')
    @include('components.sidebar', ['menuItems' => $menuItems])
@endsection

@section('content')
    @include('components.profile')

    <style>
        .breadcrumb {
            padding: 12px;
            color: #667085;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .breadcrumb span {
            color: #D0D5DD;
        }

        .breadcrumb a {
            color: inherit;
            text-decoration: none;
            cursor: pointer;
        }

        .accordion-container {
            width: 100%;
            padding: 16px;
        }

        .accordion-item {
            width: 100%;
            margin-bottom: 16px;
            border-radius: 8px;
            overflow: hidden;
            background-color: #F0F0F0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .accordion-button {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 16px;
            font-weight: 500;
            color: #6b7280;
            background-color: #F0F0F0;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s;
        }

        .accordion-button:hover {
            background-color: #2E3646;
            color: white;
        }

        .unit-header {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .unit-image {
            width: 50px;
            height: 44px;
            border-radius: 4px;
        }

        .unit-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .accordion-body {
            display: none;
            width: 100%;
            background-color: white;
            padding: 16px;
        }

        .accordion-body.open {
            display: block;
        }

        .chapters {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }

        .chapter-card {
            width: calc(33.33% - 12px);
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .chapter-card img {
            width: 100%;
            height: 250px;
            object-fit: contain;
        }

        .chapter-title {
            padding: 8px;
            font-size: 1.25rem;
            font-weight: 600;
            color: #1F2937;
            text-align: center;
        }

        .accordion-icon {
            width: 16px;
            height: 16px;
            transition: transform 0.3s;
        }

        .accordion-icon.rotate-180 {
            transform: rotate(180deg);
        }
    </style>

    <div class="breadcrumb">
        <i class="fa-solid fa-house"></i>
        <span>/</span>
        <a href="{{ route('teacher.dashboard') }}">Grade</a>
        <span>/</span>
        <a href="{{ route('teacher.info', $material->stage_id) }}">Info</a>
        <span>/</span>
        <a href="{{ route('teacher.showMaterials', $material->stage_id) }}">Theme</a>
        <span>/</span>
        <a href="#">Units</a>
    </div>

    <div class="accordion-container">
        @foreach ($material->units as $unit)
            <div class="accordion-item">
                <h2>
                    <button class="accordion-button" data-accordion-target="#accordion-body-{{ $unit->id }}">
                        <div class="unit-header">
                            <img src="{{ asset('images/unit' . min($loop->iteration, 3) . '.png') }}" class="unit-image">
                            <span class="unit-title">{{ $unit->title }}</span>
                        </div>
                        <svg class="accordion-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                d="M9 5L5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-body-{{ $unit->id }}" class="accordion-body">
                    <div class="chapters">
                        @forelse ($unit->chapters as $chapter)
                            <div class="chapter-card">
                                <a href="{{ route('teacher.lessons.index', $chapter->id) }}">
                                    <img src="{{ $chapter->image ? asset($chapter->image) : asset('images/defaultCard.webp') }}"
                                        alt="{{ $chapter->title }}">
                                    <p class="chapter-title">{{ $chapter->title }}</p>
                                </a>
                            </div>
                        @empty
                            <p>No chapters available </p>
                        @endforelse
                    </div>

                </div>
            </div>
        @endforeach
    </div>

    <script>
        document.querySelectorAll('.accordion-button').forEach(button => {
            button.addEventListener('click', () => {
                const target = button.getAttribute('data-accordion-target');
                const body = document.querySelector(target);
                const icon = button.querySelector('svg');

                body.classList.toggle('open');
                icon.classList.toggle('rotate-180');
            });
        });
    </script>
@endsection
