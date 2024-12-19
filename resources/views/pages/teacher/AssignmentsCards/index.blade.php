@extends('pages.teacher.teacher')

@section('title')
    Assignments
@endsection


@php
    $paths = [
        ["name" => "Grade", "url" => "teacher.theme"],
        ["name" => "Material", "url" => "teacher.material"],
        ["name" => "Theme", "url" => "teacher.theme"],
        ["name" => "Unit", "url" => "teacher.unit"],
        ["name" => "Chapter", "url" => "teacher.chapter"],
        ["name" => "Lesson", "url" => "teacher.lesson"],
        ["name" => "Assignments", "url" => "teacher.assignments_cards"]
    ];
    $cards = [
        ["title" => "g1", "url" => "teacher.class"],
        ["title" => "g1", "url" => "teacher.class"],
        ["title" => "g1", "url" => "teacher.class"],
        ["title" => "g1", "url" => "teacher.class"],
        ["title" => "g1", "url" => "teacher.class"],
        ["title" => "g1", "url" => "teacher.class"],
        ["title" => "g1", "url" => "teacher.class"]
    ]
@endphp

@section("InsideContent")
    @include('components.path', ["paths" => $paths])
    @include('components.cards', ["cards" => $cards])
@endsection
