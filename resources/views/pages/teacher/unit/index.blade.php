@extends('pages.teacher.teacher')

@section('title')
    Unit
@endsection


@php
    $paths = [
        ["name" => "Grade", "url" => "teacher.theme"],
        ["name" => "Material", "url" => "teacher.material"],
        ["name" => "Theme", "url" => "teacher.theme"],
        ["name" => "Unit", "url" => "teacher.unit"],
    ];
    $cards = [
        ["title" => "material", "url" => "teacher.chapter"],
        ["title" => "material", "url" => "teacher.chapter"],
        ["title" => "material", "url" => "teacher.chapter"],
        ["title" => "material", "url" => "teacher.chapter"],
        ["title" => "material", "url" => "teacher.chapter"],
        ["title" => "material", "url" => "teacher.chapter"],
        ["title" => "material", "url" => "teacher.chapter"]
    ]
@endphp

@section("InsideContent")
    @include('components.path', ["paths" => $paths])
    @include('components.cards', ["cards" => $cards])
@endsection
