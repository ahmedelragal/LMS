<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StudentsExport;
use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Models\Group;
use App\Models\School;
use App\Models\Stage;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ReportController extends Controller
{


    public function getSchoolStudents($schoolId)
    {
        $students =  Student::where('school_id', $schoolId)->get();
        return response()->json($students);
    }

    public function homeworkReport(Request $request)
    {
        $schools = School::all();
        $stages = Stage::all();
        $classes = Group::all();
        $teachers = Teacher::all();
        $students = Student::all();

        return view('admin.reports.homeworkreport', compact('schools', 'stages', 'classes', 'teachers', 'students'));
    }
}
