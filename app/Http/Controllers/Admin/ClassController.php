<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StudentsExport;
use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Models\Group;
use App\Models\School;
use App\Models\Stage;
use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Storage;

class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Group::query();

        if ($request->filled('school_id')) {
            $query->where('school_id', $request->school_id);
        }

        $classes = $query->paginate(20);
        $schools = School::all();

        return view('admin.classes.index', compact('classes', 'schools'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schools = School::all();
        $stages = Stage::all();
        return view('admin.classes.create', compact('schools', 'stages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'school_id' => 'required|exists:schools,id',
            'stage_id' => 'required|exists:stages,id',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('classes', 'public');
        }
        $class = Group::create([
            'name' => $request->input('name'),
            'school_id' => $request->input('school_id'),
            'stage_id' => $request->input('stage_id'),
            'image' => $imagePath,
        ]);

        return redirect()->route('classes.index')->with('success', 'Class created successfully.');
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
        $class = Group::findOrFail($id);
        $schools = School::all();
        $stages = Stage::all();

        return view('admin.classes.edit', compact('class', 'schools', 'stages'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $class = Group::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'school_id' => 'required|exists:schools,id',
            'stage_id' => 'required|exists:stages,id',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('classes', 'public');
            if ($class->image) {
                Storage::disk('public')->delete($class->image);
            }
            $class->image = $imagePath;
        }

        $class->update([
            'name' => $request->input('name'),
            'school_id' => $request->input('school_id'),
            'stage_id' => $request->input('stage_id'),
        ]);

        $class->save();

        return redirect()->route('classes.index')->with('success', 'Class updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $class = Group::findOrFail($id);
        $class->delete();
        return redirect()->route('classes.index')->with('success', 'Class deleted successfully.');
    }
    public function showImportForm($id)
    {
        $class = Group::findOrFail($id);
        return view('admin.classes.import', compact('class'));
    }
    public function importStudents(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $import = new StudentsImport($id);

        try {
            // Import the file
            \Excel::import($import, $request->file('file'));

            // Check if there are any duplicate usernames
            if (!empty($import->duplicateUsernames)) {
                $duplicates = implode(', ', $import->duplicateUsernames);
                return back()->withErrors(['file' => "Duplicate usernames found: $duplicates"]);
            }

            return redirect()->route('classes.index')->with('success', 'Students imported successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                return back()->withErrors(['file' => 'A student with the same username already exists.']);
            }
            return back()->withErrors(['file' => 'Database error: ' . $e->getMessage()]);
        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'Import error: ' . $e->getMessage()]);
        }
    }

    public function exportStudents($id)
    {
        $class = Group::findOrFail($id);
        $fileName = 'students_' . $class->name . '.xlsx';

        return Excel::download(new StudentsExport($id), $fileName);
    }
}
