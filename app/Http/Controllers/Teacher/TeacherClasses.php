<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student_assessment;
use App\Models\TeacherClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherClasses extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($stage_id)
    {
        // $userAuth = auth()->guard('teacher')->user();
        // if ($userAuth) {
        //     $classesTeachers = TeacherClass::where('teacher_id', $userAuth->id)->get();


        //     return view('pages.teacher.Class.index', compact('classesTeachers', "userAuth"));
        // } else {
        //     return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
        // }


        $userAuth = auth()->guard('teacher')->user();

        if (!$userAuth) {
            return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
        }

        $classesTeachers = TeacherClass::where('teacher_id', $userAuth->id)
            ->whereHas('class', function ($query) use ($stage_id) {
                $query->where('stage_id', $stage_id);
            })
            ->with('class')
            ->get();

        return view('pages.teacher.Class.index', compact('classesTeachers', 'userAuth'));

    }
    public function students(string $class_id)
    {
        $userAuth = auth()->guard('teacher')->user();

        if (!$userAuth) {
            return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
        }
        $class = TeacherClass::with(['students.studentAssessment'])
            ->where('class_id', $class_id)
            ->where('teacher_id', $userAuth->id)
            ->get();
        if (!$class) {
            return redirect()->route('teacher_classes')->withErrors(['error' => 'Class not found or unauthorized access.']);
        }


        $students = $class->pluck('students');
        $numberOfWeeks = 8;
        $weeks = range(1, $numberOfWeeks);


        return view('components.GradesTable', compact('students', 'class', 'weeks'));
    }






    // public function storeAssessment(Request $request)
    // {
    //     $request->validate([
    //         'student_id' => 'required|exists:students,id',
    //         'week' => 'required|integer|min:1|max:8',
    //         'attendance_score' => 'nullable|integer|min:0|max:10',
    //         'classroom_participation_score' => 'nullable|integer|min:0|max:20',
    //         'classroom_behavior_score' => 'nullable|integer|min:0|max:20',
    //         'homework_score' => 'nullable|integer|min:0|max:10',
    //         'final_project_score' => 'nullable|integer|min:0|max:50',
    //     ]);

    //     // Fetch or create the assessment for the student for the given week
    //     // dd(Carbon::parse(date('Y-m-d')));
    // $assessment = Student_assessment::where([
    //     'student_id' => $request->student_id,
    //     'teacher_id' => auth()->guard('teacher')->id(),
    //     // 'week' => $request->week,
    // ])->whereBetween('created_at', [Carbon::parse(date('Y-m-d'))->startOfDay(), Carbon::parse(date('Y-m-d'))->end])->first();
    //     if (!$assessment) {
    //         $assessment = Student_assessment::where([
    //             'student_id' => $request->student_id,
    //             'teacher_id' => auth()->guard('teacher')->id(),
    //             // 'week' => $request->week,
    //         ]);
    //     }
    //     // dd($assessment);

    //     // Update the fields
    //     $assessment->attendance_score = $request->attendance_score ?? $assessment->attendance_score;
    //     $assessment->classroom_participation_score = $request->classroom_participation_score ?? $assessment->classroom_participation_score;
    //     $assessment->classroom_behavior_score = $request->classroom_behavior_score ?? $assessment->classroom_behavior_score;
    //     $assessment->homework_score = $request->homework_score ?? $assessment->homework_score;

    //     if ($request->week == 8) {
    //         $assessment->final_project_score = $request->final_project_score ?? $assessment->final_project_score;
    //     }

    //     // Save the assessment
    //     $assessment->save();

    //     return response()->json(['success' => true, 'message' => 'Assessment saved successfully.']);
    // }





    /**
     * Show the form for creating a new resource.
     */
    public function storeAssessment(Request $request)
    {
        // date_default_timezone_set('Africa/Cairo'); 
        // dd(Carbon::parse(now())->endOfWeek());
        // dd($request->all());
        // Validate the incoming request data
        $request->validate([
            // 'student_id' => 'required|exists:students,id',
            // 'week' => 'required|integer|min:1|max:8',
            // 'attendance_score' => 'nullable|integer|min:0|max:10',
            // 'classroom_participation_score' => 'nullable|integer|min:0|max:20',
            // 'classroom_behavior_score' => 'nullable|integer|min:0|max:20',
            // 'homework_score' => 'nullable|integer|min:0|max:10',
            // 'final_project_score' => 'nullable|integer|min:0|max:50',
            'student_id' => 'required|exists:students,id',
            // 'week' => 'required|integer|min:1|max:8',
            'attendance_score' => 'nullable|integer|min:0|max:10',
            'classroom_participation_score' => 'nullable|integer|min:0|max:20',
            'classroom_behavior_score' => 'nullable|integer|min:0|max:20',
            'homework_score' => 'nullable|integer|min:0|max:10',
            'final_project_score' => 'nullable|integer|min:0|max:50',
        ]);

        // Get the current teacher's ID
        $teacherId = auth()->guard('teacher')->id();
        // Check if the assessment already exists for the specified week
        $assessment = Student_assessment::where([
            'student_id' => $request->student_id,
            'teacher_id' => $teacherId
        ])->whereBetween('created_at', values: [Carbon::parse(now())->startOfWeek(), Carbon::parse(now())->endOfWeek()])->first();

        if (!$assessment) {
            // Create a new assessment for the week if none exists
            $assessment = new Student_assessment();
            $assessment->student_id = $request->student_id;
            $assessment->teacher_id = $teacherId;
            // $assessment->week = $request->week;
        }

        // Update the assessment scores with the provided data
        $assessment->attendance_score = $request->attendance_score ?? $assessment->attendance_score;
        $assessment->classroom_participation_score = $request->classroom_participation_score ?? $assessment->classroom_participation_score;
        $assessment->classroom_behavior_score = $request->classroom_behavior_score ?? $assessment->classroom_behavior_score;
        $assessment->homework_score = $request->homework_score ?? $assessment->homework_score;
        // Only update the final project score if the current week is 8
        // if ($request->week == 8) {
        //     $assessment->final_project_score = $request->final_project_score ?? $assessment->final_project_score;
        // }
// dd($request->all());
// Save the assessment record (create or update)
        $assessment->save();
        // dd($assessment);
// dd($assessment);
        return response()->json(['success' => true, 'message' => 'Assessment saved successfully.']);
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userAuth = auth()->guard('teacher')->user();

        if (!$userAuth) {
            return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
        }

        $StudentAssessment = Student_assessment::where('student_id', $id)->get();

        if (!$StudentAssessment) {
            return redirect()->route('teacher_classes')->withErrors(['error' => 'Class not found or unauthorized access.']);
        }

        dd($StudentAssessment);


        return view('components.GradeTableForOneStudent', compact('StudentAssessment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
