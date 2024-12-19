<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Lesson;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assignments = Assignment::with(['lesson', 'school'])->get();
        return view('admin.assignments.index', compact('assignments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lessons = Lesson::all();
        $schools = School::all();
        return view('admin.assignments.create', compact('lessons', 'schools'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'school_id' => 'required|exists:schools,id',
            'lesson_id' => 'required|exists:lessons,id',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
            'path_file' => 'nullable|file',
            'link' => 'nullable|url',
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'marks' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $filePath = null;
        if ($request->hasFile('path_file')) {
            $filePath = $request->file('path_file')->store('assignments', 'public');
        }
        $assignment = Assignment::create([
            'title' => $request->title,
            'description' => $request->description,
            'path_file' => $filePath,
            'link' => $request->link,
            'start_date' => $request->start_date,
            'due_date' => $request->due_date,
            'lesson_id' => $request->lesson_id,
            'school_id' => $request->school_id,
            'marks' => $request->marks,
            'is_active' => $request->is_active ?? 0,
            'teacher_id' => auth()->user()->id,
        ]);

        // Attach students to the assignment

        DB::table('assignment_stage')->insert([
            'assignment_id' => $assignment->id,
            'school_id' => $request->school_id,
            'stage_id' => $request->stage_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        foreach ($request->student_ids as $studentId) {
            DB::table('assignment_student')->insert([
                'assignment_id' => $assignment->id,
                'student_id' => $studentId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        // $assignment->students()->attach($request->student_ids);

        // Assignment::create([
        //     'title' => $request->title,
        //     'description' => $request->description,
        //     'path_file' => $filePath,
        //     'link' => $request->link,
        //     'start_date' => $request->start_date,
        //     'due_date' => $request->due_date,
        //     'lesson_id' => $request->lesson_id,
        //     'school_id' => $request->school_id,
        //     'marks' => $request->marks,
        //     'is_active' => $request->is_active ?? 0,
        // ]);

        return redirect()->route('assignments.index')->with('success', 'Assignment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $assignment = Assignment::with(['lesson', 'school', 'students'])->findOrFail($id);
        return view('admin.assignments.show', compact('assignment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $assignment = Assignment::findOrFail($id);

        // Fetch all lessons and schools
        $lessons = Lesson::all();
        $schools = School::all();

        // Fetch stages for the selected school
        $stages = DB::table('school_stage')
            ->where('school_id', $assignment->school_id)
            ->join('stages', 'school_stage.stage_id', '=', 'stages.id')
            ->select('stages.id', 'stages.name')
            ->get();

        // Fetch the selected stage from the `assignment_stage` table
        $selectedStage = DB::table('assignment_stage')
            ->where('assignment_id', $assignment->id)
            ->value('stage_id');

        // Fetch all students of the selected stage
        $students = DB::table('students')
            ->where('stage_id', $selectedStage)
            ->get();

        // Fetch the selected students from `assignment_student` table
        $selectedStudents = DB::table('assignment_student')
            ->where('assignment_id', $assignment->id)
            ->pluck('student_id')
            ->toArray();

        return view('admin.assignments.edit', compact('assignment', 'lessons', 'schools', 'stages', 'students', 'selectedStage', 'selectedStudents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $assignment = Assignment::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'school_id' => 'required|exists:schools,id',
            'lesson_id' => 'required|exists:lessons,id',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
            'path_file' => 'nullable|file',
            'link' => 'nullable|url',
            'start_date' => 'required|date',
            'due_date' => 'required|date',
            'marks' => 'required|integer',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle file upload if exists
        if ($request->hasFile('path_file')) {
            $filePath = $request->file('path_file')->store('assignments', 'public');
            $assignment->path_file = $filePath;
        }

        // Update the assignment
        $assignment->update([
            'title' => $request->title,
            'description' => $request->description,
            'link' => $request->link,
            'start_date' => $request->start_date,
            'due_date' => $request->due_date,
            'lesson_id' => $request->lesson_id,
            'school_id' => $request->school_id,
            'marks' => $request->marks,
            'is_active' => $request->is_active ?? 0,
        ]);

        // Update assignment_stage
        DB::table('assignment_stage')
            ->where('assignment_id', $assignment->id)
            ->update([
                'school_id' => $request->school_id,
                'stage_id' => $request->stage_id,
                'updated_at' => now(),
            ]);

        // Update assignment_student
        DB::table('assignment_student')
            ->where('assignment_id', $assignment->id)
            ->delete();

        foreach ($request->student_ids as $studentId) {
            DB::table('assignment_student')->insert([
                'assignment_id' => $assignment->id,
                'student_id' => $studentId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('assignments.index')->with('success', 'Assignment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
  
}
