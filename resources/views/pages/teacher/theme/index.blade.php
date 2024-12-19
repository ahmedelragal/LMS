@extends('pages.teacher.teacher')

@section('title')
    Theme
@endsection


@php
    $paths = [
        ["name" => "Grade", "url" => "teacher.grade"],
        ["name" => "Material", "url" => "teacher.material"],
        ["name" => "Theme", "url" => "teacher.theme"],

    ];
    $cards = [
        ["title" => "material", "url" => "teacher.unit"],
        ["title" => "material", "url" => "teacher.unit"],
        ["title" => "material", "url" => "teacher.unit"],
        ["title" => "material", "url" => "teacher.unit"],
        ["title" => "material", "url" => "teacher.unit"],
        ["title" => "material", "url" => "teacher.unit"],
        ["title" => "material", "url" => "teacher.unit"]
    ]
@endphp

@section("InsideContent")
    @include('components.path', ["paths" => $paths])
    @include('components.cards', ["cards" => $cards])
@endsection
