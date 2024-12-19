@extends('pages.teacher.teacher')

@section('title')
    Material
@endsection


@php
    $paths = [
        ["name" => "Grade", "url" => "teacher.grade"],
        ["name" => "Material", "url" => "teacher.material"]
    ];
    $cards = [
        ["title" => "material", "url" => "teacher.theme"],
        ["title" => "material", "url" => "teacher.theme"],
        ["title" => "material", "url" => "teacher.theme"],
        ["title" => "material", "url" => "teacher.theme"],
        ["title" => "material", "url" => "teacher.theme"],
        ["title" => "material", "url" => "teacher.theme"],
        ["title" => "material", "url" => "teacher.theme"]
    ]
@endphp

@section("InsideContent")
    @include('components.path', ["paths" => $paths])
    @include('components.cards', ["cards" => $cards])
@endsection
