<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Student_assessment;
use App\Models\TeacherClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentAssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function index()
    // {
    //     $userAuth = auth()->guard('student')->user();
    //     if ($userAuth) {
    //         $students = Student::with([
    //             'studentAssessment' => function ($query) {
    //                 $query->latest(); // Fetch the latest assessment for each student
    //             }
    //         ])->get();

    //         return view('pages.teacher.assessments.index', compact('students', "userAuth"));
    //     } else {
    //         return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
    //     }

    // }
    public function index(Request $request)
    {
        $userAuth = auth()->guard('teacher')->user();
        if ($userAuth) {
            // Get the class_id from the request
            $classId = $request->input('class_id');

            // Retrieve the students for the selected class
            $students = Student::where('class_id', $classId)
                ->with([
                    'studentAssessment' => function ($query) {
                        $query->latest(); // Fetch the latest assessment for each student
                    }
                ])
                ->get();

            return view('pages.teacher.assessments.index', compact('students', 'userAuth'));
        } else {
            return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userAuth = Auth::user();
        if ($userAuth) {
            $students = Student::where('school_id', $userAuth->school_id)
                ->whereIn('stage_id', $userAuth->stages->pluck('id'))
                ->get();

                $classId = $students[0]->class_id;
            return view('pages.teacher.assessments.create', compact('students', "userAuth", "classId"));
        } else {
            return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'assessments' => 'required|array',
            'assessments.*.student_id' => 'required|exists:students,id',
            'assessments.*.attendance_score' => 'nullable|integer|min:0|max:10',
            'assessments.*.classroom_participation_score' => 'nullable|integer|min:0|max:15',
            'assessments.*.classroom_behavior_score' => 'nullable|integer|min:0|max:15',
            'assessments.*.homework_score' => 'nullable|integer|min:0|max:10',
            'assessments.*.final_project_score' => 'nullable|integer|min:0|max:50',
        ]);

        $today = now()->toDateString();
         

        foreach ($request->assessments as $assessmentData) {
            $existingAssessment = Student_assessment::where('student_id', $assessmentData['student_id'])
                ->whereDate('created_at', $today)
                ->first();

            if ($existingAssessment) {
                continue;
            }
          

            Student_assessment::create([
                'student_id' => $assessmentData['student_id'],
                'teacher_id' => Auth::id(),
                'attendance_score' => $assessmentData['attendance_score'] ?? 0,
                'classroom_participation_score' => $assessmentData['classroom_participation_score'] ?? 0,
                'classroom_behavior_score' => $assessmentData['classroom_behavior_score'] ?? 0,
                'homework_score' => $assessmentData['homework_score'] ?? 0,
                'final_project_score' => $assessmentData['final_project_score'] ?? 0,
            ]);
        }
$userAuth = auth()->guard('teacher')->user();
$student = $assessmentData['student_id'];
$assessments = Student_assessment::where('student_id', $assessmentData['student_id'])->get();

        return view('pages.teacher.assessments.student', compact('student', 'assessments', "userAuth"))->with('success', 'Assessments added successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    public function showStudentAssessments($student_id)
    {
        $userAuth = auth()->guard('teacher')->user();
        if ($userAuth) {
            $student2 = Student::findOrFail($student_id);

            $assessments = Student_assessment::where('student_id', $student_id)->get();
            $classId = $student2->class_id;
            // dd($student);
            return view('components.GradeTableForOneStudent', compact('student2', 'assessments', "userAuth", 'classId'));
        } else {
            return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
        }

    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $assessment = Student_assessment::findOrFail($id);
        $students = Student::all();
        return view('teacher.assessments.edit', compact('assessment', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $student_id)
    {
        $request->validate([
            'attendance_score' => 'nullable|integer|min:0|max:10',
            'classroom_participation_score' => 'nullable|integer|min:0|max:15',
            'classroom_behavior_score' => 'nullable|integer|min:0|max:15',
            'homework_score' => 'nullable|integer|min:0|max:10',
            'final_project_score' => 'nullable|integer|min:0|max:50',
        ]);

        $assessment = Student_assessment::firstOrCreate([
            'student_id' => $student_id,
            'teacher_id' => Auth::id(), // Current teacher's ID
        ]);

        $assessment->update($request->only([
            'attendance_score',
            'classroom_participation_score',
            'classroom_behavior_score',
            'homework_score',
            'final_project_score'
        ]));

        return redirect()->back()->with('success', 'Assessment updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $assessment = Student_assessment::findOrFail($id);
        $classId = $assessment->class_id;
        $assessment->delete();
        return redirect()->route('teacher.assessments.index', ['class_id' => $classId])->with('success', 'Assessment deleted successfully.');
    }
}
