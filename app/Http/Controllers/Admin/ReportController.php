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
use App\Models\Assignment;
use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{


    public function getSchoolStudents($schoolId)
    {
        $students =  Student::where('school_id', $schoolId)->get();
        return response()->json($students);
    }

    public function assignmentAvgReport(Request $request)
    {
        $schools = School::all();
        $stages = Stage::all();
        $classes = Group::all();
        $teachers = Teacher::all();
        $students = Student::all();

        $query = Assignment::query();

        // Filter by school
        if ($request->filled('school_id')) {
            $query->where('school_id', $request->school_id);
            if (!$query->exists()) {
                $schoolName = School::where('id', $request->school_id)->value('name');
                return redirect()->back()->with('error', "No Assignments found in School: $schoolName");
            }
        }

        // Filter by teacher
        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
            if (!$query->exists()) {
                $teacherUsername = Teacher::where('id', $request->teacher_id)->value('username');
                return redirect()->back()->with('error', "No Assignments found for Teacher: $teacherUsername");
            }
        }

        $filteredAssignments = $query->pluck('id');

        if ($filteredAssignments->isEmpty()) {
            return redirect()->back()->with('error', 'No assignments found based on the applied filters.');
        }

        $assignments = DB::table('assignment_stage')
            ->whereIn('assignment_id', $filteredAssignments)
            ->get();

        $stages = Stage::whereIn('id', $assignments->pluck('stage_id'))->get()->keyBy('id');
        $allAssignments = Assignment::whereIn('id', $assignments->pluck('assignment_id'))->get()->keyBy('id');

        $studentAssignments = DB::table('assignment_student')
            ->whereIn('assignment_id', $filteredAssignments)
            ->whereNotNull('submitted_at')
            ->get();

        $data = [];
        foreach ($assignments as $assignment) {
            $stageId = $assignment->stage_id;
            $assignmentId = $assignment->assignment_id;

            if (!isset($data[$stageId])) {
                $data[$stageId] = [
                    'stage_id' => $stageId,
                    'stage_name' => $stages[$stageId]->name,
                    'assignments' => [],
                ];
            }

            if (!isset($data[$stageId]['assignments'][$assignmentId])) {
                $data[$stageId]['assignments'][$assignmentId] = [
                    'assignment_id' => $assignmentId,
                    'assignment_name' => $allAssignments[$assignmentId]->title,
                    'students' => [],
                    'students_average' => 0,
                ];
            }
        }

        foreach ($studentAssignments as $studentAssignment) {
            $stageId = DB::table('assignment_stage')
                ->where('assignment_id', $studentAssignment->assignment_id)
                ->value('stage_id');

            $assignmentId = $studentAssignment->assignment_id;
            $data[$stageId]['assignments'][$assignmentId]['students'][] = $studentAssignment->student_id;
            if ($studentAssignment->marks !== null) {
                $data[$stageId]['assignments'][$assignmentId]['students_average'] += $studentAssignment->marks;
            }
        }

        // Calculate averages
        foreach ($data as $stageId => $stage) {
            foreach ($stage['assignments'] as $assignmentId => $assignment) {
                $studentCount = count($assignment['students']);
                if ($studentCount > 0) {
                    $data[$stageId]['assignments'][$assignmentId]['students_average'] = round($assignment['students_average'] / $studentCount, 2);
                }
            }
        }

        // Prepare Chart.js data
        $chartData = [];

        // Process each grade (stage)
        foreach ($data as $stage) {
            $grade = [
                'grade' => $stage['stage_name'], // Grade name
                'assignments' => [] // Initialize assignments array
            ];

            // Add assignments to the grade
            foreach ($stage['assignments'] as $assignment) {
                $grade['assignments'][] = [
                    'name' => $assignment['assignment_name'], // Assignment name
                    'degree' => $assignment['students_average'] // Assignment degree (students average)
                ];
            }

            // Add the grade with assignments to the chart data
            $chartData[] = $grade;
        }
        return view('admin.reports.assignment_avg_report', compact('chartData', 'schools', 'stages', 'classes', 'teachers', 'students'));
    }
}
