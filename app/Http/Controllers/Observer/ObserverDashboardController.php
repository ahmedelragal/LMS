<?php

namespace App\Http\Controllers\Observer;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Material;
use App\Models\Observation;
use App\Models\ObservationHeader;
use App\Models\ObservationHistory;
use App\Models\ObservationQuestion;
use App\Models\School;
use App\Models\Stage;
use App\Models\Teacher;
use App\Models\Unit;
use Auth;
use Illuminate\Http\Request;
use DB;

class ObserverDashboardController extends Controller
{
    public function index(Request $request)
    {
        $observer = Auth::guard('observer')->user();
        $teachers = Teacher::all();
        if ($request->filled('teacher_id')) {
            $observations = Observation::where('teacher_id', $request->teacher_id)->get();
        } else {
            $observations = Observation::all();
        }

        return view('pages.observer.observer', compact('teachers', 'observer', 'observations'));
    }
    public function createObservation()
    {
        $observer = Auth::guard('observer')->user();
        $observations = Observation::all();
        $teachers = Teacher::all();
        $headers = ObservationHeader::all();
        return view('pages.observer.create_observation', compact('observer', 'observations', 'teachers', 'headers'));
    }
    public function getSchool($teacherId)
    {
        $teacher = Teacher::find($teacherId);
        if (!$teacher) {
            return response()->json(['error' => 'Teacher not found'], 404);
        }
        $school = School::find($teacher->school_id);
        if (!$school) {
            return response()->json(['error' => 'School not found'], 404);
        }
        return response()->json($school);
    }

    public function getStages($teacherId)
    {
        $teacher = Teacher::find($teacherId);
        if (!$teacher) {
            return response()->json(['error' => 'Teacher not found'], 404);
        }
        $stages = DB::table('teacher_stage')
            ->where('teacher_id', $teacherId)
            ->join('stages', 'teacher_stage.stage_id', '=', 'stages.id')
            ->select('stages.id', 'stages.name')
            ->get();

        return response()->json($stages);
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'observer_id' => 'required|integer',
            'teacher_id' => 'required|integer',
            'coteacher_id' => 'nullable|integer',
            'grade_id' => 'required|integer',
            'date' => 'required|date',
            '_token' => 'required',
        ]);

        $teacher = Teacher::find($request->teacher_id);
        $coteacher = Teacher::find($request->coteacher_id);

        $observation = Observation::create([
            'teacher_name' => $teacher->username,
            'observer_id' => $request->observer_id,
            'teacher_id' => $request->teacher_id,
            'stage_id' => $request->grade_id,
            'school_id' => $teacher->school_id,
            'activity' => $request->date,
            'coteacher_id' => $request->coteacher_id,
            'coteacher_name' => $coteacher->username ?? null, // Fix for coteacher name
            'material_id' => null,
            'note' => $request->note,
        ]);

        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key, 'question-')) {
                $questionId = str_replace('question-', '', $key);
                ObservationHistory::create([
                    'observation_id' => $observation->id,
                    'question_id' => $questionId,
                    'rate' => $value,
                ]);
            }
        }

        return redirect()->route('observer.dashboard')->with('success', 'Observation created successfully!');
    }
    public function destroy(string $id)
    {
        $observation = Observation::findOrFail($id);
        $observation->delete();
        return redirect()->route('observer.dashboard')->with('success', 'Observation deleted successfully.');
    }
    public function view(string $id)
    {
        $observer = Auth::guard('observer')->user();
        $headers = ObservationHeader::all();
        $observation = Observation::find($id);
        $answers = ObservationHistory::where('observation_id', $id)->get();
        return view('pages.observer.view_observation', compact('observer', 'headers', 'observation', 'answers'));
    }
    public function report(Request $request)
    {
        $teachers = Teacher::all();
        $observer = Auth::guard('observer')->user();
        $headers = ObservationHeader::all();
        $stages = Stage::all();
        foreach ($headers as $header) {
            if (!isset($data[$header->id])) {
                $data[$header->id] = [
                    'header_id' => $header->id,
                    'name' => $header->header,
                    'questions' => [],
                ];
            }
            $questions = ObservationQuestion::where('observation_header_id', $header->id)->get();
            $headerQuestions = [];
            foreach ($questions as $question) {
                if (!isset($headerQuestions[$question->id])) {
                    $headerQuestions[$question->id] = [
                        'question_id' => $question->id,
                        'name' => $question->question,
                        'avg_rating' => 0,
                        'max_rating' => $question->max_rate,
                    ];
                }
            }
            $data[$header->id]['questions'] = $headerQuestions;
        }
        // dd($data);

        $query = Observation::query();

        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }
        if ($query->get()->count() == 0) {
            return redirect()->back()->with('error', 'No observations found for teacher: ' . Teacher::find($request->teacher_id)->username);
        }

        if ($request->filled('stage_id')) {
            $query->where('stage_id', $request->stage_id);
        }
        if ($query->get()->count() == 0) {
            return redirect()->back()->with('error', 'No observations found for ' . Stage::find($request->stage_id)->name);
        }

        $observations = $query->pluck('id');

        $obsCount = $observations->count();


        // dd($obsCount);
        $histories = ObservationHistory::whereIn('observation_id', $observations)->get();
        // dd($history);
        foreach ($histories as $history) {
            $headerId = ObservationQuestion::find($history->question_id)->observation_header_id;
            $data[$headerId]['questions'][$history->question_id]['avg_rating'] += $history->rate;
        }

        foreach ($data as $header) {
            foreach ($header['questions'] as $question) {
                $data[$header['header_id']]['questions'][$question['question_id']]['avg_rating'] = round($data[$header['header_id']]['questions'][$question['question_id']]['avg_rating'] / $obsCount, 2);
            }
        }

        return view('pages.observer.observation_report', compact('stages', 'teachers', 'observer', 'headers', 'data'));
    }
}
