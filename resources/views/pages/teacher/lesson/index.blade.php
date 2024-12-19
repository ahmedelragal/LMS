@extends('pages.teacher.teacher')

@section('title')
    Lesson
@endsection


@php
    $paths = [
        ["name" => "Grade", "url" => "teacher.theme"],
        ["name" => "Material", "url" => "teacher.material"],
        ["name" => "Theme", "url" => "teacher.theme"],
        ["name" => "Unit", "url" => "teacher.unit"],
        ["name" => "Chapter", "url" => "teacher.chapter"],
        ["name" => "Lesson", "url" => "teacher.lesson"],
    ];
    $cards = [
        ["title" => "material", "url" => "teacher.assignments_cards"],
        ["title" => "material", "url" => "teacher.assignments_cards"],
        ["title" => "material", "url" => "teacher.assignments_cards"],
        ["title" => "material", "url" => "teacher.assignments_cards"],
        ["title" => "material", "url" => "teacher.assignments_cards"],
        ["title" => "material", "url" => "teacher.assignments_cards"],
        ["title" => "material", "url" => "teacher.assignments_cards"]
    ]
@endphp

@section("InsideContent")
    @include('components.path', ["paths" => $paths])
    @include('components.cards', ["cards" => $cards])
@endsection
