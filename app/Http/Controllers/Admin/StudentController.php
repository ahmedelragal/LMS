<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Stage;
use App\Models\Student;
use App\Models\Group;
use App\Models\StudentClass;
use Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Str;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $StudentQuery = Student::with('school', 'stage');

        $schools = School::all();
        $classes = Group::all();

        if ($request->has('school') && $request->school != null) {
            $StudentQuery->where('school_id', $request->school);
        }

        if ($request->has('class') && $request->class != null) {
            $StudentQuery->where('class_id', $request->class);
        }

        $students = $StudentQuery->paginate(30)->appends($request->query());

        return view('admin.students.index', compact('students', 'schools', 'classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schools = School::all();
        $stages = Stage::all();
        return view('admin.students.create', compact('schools', 'stages'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->merge([
            'username' => str_replace(' ', '_', $request->input('username'))
        ]);

        $request->validate([
            'username' => [
                'required',
                'regex:/^[a-zA-Z][a-zA-Z0-9_]*$/',
                Rule::unique('students')->where(function ($query) use ($request) {
                    return $query->where('school_id', $request->input('school_id'))
                        ->where('stage_id', $request->input('stage_id'));
                }),
            ],
            'gender' => 'required',
            'school_id' => 'required|exists:schools,id',
            'stage_id' => 'required|exists:stages,id',
            'class_id' => 'required|exists:groups,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $password = Str::random(8);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('students', 'public')
            : null;

        Student::create([
            'username' => $request->input('username'),
            'password' => Hash::make($password),
            'plain_password' => $password,
            'gender' => $request->input('gender'),
            'school_id' => $request->input('school_id'),
            'stage_id' => $request->input('stage_id'),
            'is_active' => 1,
            'image' => $imagePath,
            'class_id' => $request->class_id,
        ]);

        return redirect()->route('students.index')->with('success', 'Student created successfully.');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::with('classes')->findOrFail($id);
        $schools = School::all();
        $stages = $student->school ? $student->school->stages : [];
        $classes = \DB::table('groups')->where('stage_id', $student->stage_id)->get();

        return view('admin.students.edit', compact('student', 'schools', 'stages', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::findOrFail($id);

        $request->merge([
            'username' => str_replace(' ', '_', $request->input('username'))
        ]);

        $request->validate([
            'username' => [
                'required',
                'regex:/^[a-zA-Z][a-zA-Z0-9_]*$/',
                Rule::unique('students')->where(function ($query) use ($request) {
                    return $query->where('school_id', $request->input('school_id'))
                        ->where('stage_id', $request->input('stage_id'));
                })->ignore($student->id), // Ignore the current student for updates
            ],
            'gender' => 'required',
            'school_id' => 'required|exists:schools,id',
            'stage_id' => 'required|exists:stages,id',
            'class_id' => 'required|exists:groups,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $student->image = $request->file('image')->store('students', 'public');
        }

        $student->update([
            'username' => $request->input('username'),
            'gender' => $request->input('gender'),
            'school_id' => $request->input('school_id'),
            'stage_id' => $request->input('stage_id'),
            'class_id' => $request->input('class_id'),
            'is_active' => $request->input('is_active') ?? 1,
        ]);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }

    public function getStages($schoolId)
    {
        try {
            $school = School::findOrFail($schoolId);
            $stages = $school->stages()->get(['id', 'name']);
            return response()->json($stages);
        } catch (\Exception $e) {
            \Log::error('Error fetching stages: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch stages.'], 500);
        }
    }

    public function getClasses($schoolId, $stageId)
    {
        $classes = Group::where('school_id', $schoolId)
            ->where('stage_id', $stageId)
            ->get(['id', 'name']);
        return response()->json($classes);
    }
}
