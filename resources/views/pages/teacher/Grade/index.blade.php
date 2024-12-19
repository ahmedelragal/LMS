@extends('pages.teacher.teacher')

@section('title')
    Grade
@endsection


@php
    $paths = [
        ["name" => "Grade", "url" => "teacher.grade"]
    ];
    $cards = [
        ["title" => "g1", "url" => "teacher.material"],
        ["title" => "g1", "url" => "teacher.material"],
        ["title" => "g1", "url" => "teacher.material"],
        ["title" => "g1", "url" => "teacher.material"],
        ["title" => "g1", "url" => "teacher.material"],
        ["title" => "g1", "url" => "teacher.material"],
        ["title" => "g1", "url" => "teacher.material"]
    ]
@endphp

@section("InsideContent")
    @include('components.path', ["paths" => $paths])
    @include('components.cards', ["cards" => $cards])
@endsection
