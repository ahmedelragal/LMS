@extends('pages.teacher.teacher')

@section("title")
    Student
@endsection


@php
    $tableDataa = [
        [
            'name' => 'John Doe',
            'records' => [
                ['attendance' => '7', 'participation' => '12', 'behavior' => '12', 'homework' => '6', 'final_project' => '50'],
                ['attendance' => '8', 'participation' => '13', 'behavior' => '13', 'homework' => '5', 'final_project' => '50'],
                ['attendance' => '8', 'participation' => '13', 'behavior' => '13', 'homework' => '5', 'final_project' => '50'],
                ['attendance' => '8', 'participation' => '13', 'behavior' => '13', 'homework' => '5', 'final_project' => '50'],
                ['attendance' => '8', 'participation' => '13', 'behavior' => '13', 'homework' => '5', 'final_project' => '50'],
            ]
        ],
    ];

    $paths = [
        ["name" => "Grade", "url" => "teacher.theme"],
        ["name" => "Material", "url" => "teacher.material"],
        ["name" => "Theme", "url" => "teacher.theme"],
        ["name" => "Unit", "url" => "teacher.unit"],
        ["name" => "Chapter", "url" => "teacher.chapter"],
        ["name" => "Lesson", "url" => "teacher.lesson"],
        ["name" => "Assignments", "url" => "teacher.assignments_cards"],
        ["name" => "Class", "url" => "teacher.class"],
        ["name" => "Student", "url" => "teacher.student.grade"],
    ];
@endphp

@section("InsideContent")
    @include('components.path',['paths' => $paths])

    @include('components.GradeTableForOneStudent', ['tableData' => $tableDataa])
@endsection

