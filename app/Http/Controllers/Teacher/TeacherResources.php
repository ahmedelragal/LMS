<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Stage;
use App\Models\TeacherResource;
use Auth;
use Illuminate\Http\Request;
use Str;

class TeacherResources extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::guard('teacher')->user();

        $selectedGrade = $request->get('grade');

        $stages = Stage::whereHas('teachers', function ($query) use ($user) {
            $query->where('teacher_id', $user->id);
        })->get();

        $resources = TeacherResource::where('teacher_id', $user->id);

        if ($selectedGrade) {
            $resources->where('stage_id', $selectedGrade);
        }

        $resources = $resources->get();

        return view('pages.teacher.resources.index', compact('resources', 'stages', 'selectedGrade'));
    }
    public function create()
    {
        $user = Auth::guard('teacher')->user();

        $stages = Stage::whereHas('teachers', function ($query) use ($user) {
            $query->where('teacher_id', $user->id);
        })->get();

        return view('pages.teacher.resources.create', compact('stages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_path' => 'required|file|mimes:pdf',
            'stage_id' => 'required|exists:stages,id',
        ]);

        $user = Auth::guard('teacher')->user();
        $filePath = $request->file('file_path')->store('resources', 'public');
        $imagePath = $request->hasFile('image') ? $request->file('image')->store('resources/images', 'public') : null;

        TeacherResource::create([
            'teacher_id' => $user->id,
            'school_id' => $user->school_id,
            'stage_id' => $request->stage_id,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath,
            'file_path' => $filePath,
            'type' => 'pdf',
        ]);

        return redirect()->route('teacher.resources.index')->with('success', 'Resource created successfully!');
    }
    public function edit($id)
    {
        $user = Auth::guard('teacher')->user();
        $resource = TeacherResource::where('teacher_id', $user->id)->findOrFail($id);
        $stages = Stage::whereHas('teachers', function ($query) use ($user) {
            $query->where('teacher_id', $user->id);
        })->get();

        return view('pages.teacher.resources.edit', compact('resource', 'stages'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'file_path' => 'nullable|file|mimes:pdf',
            'stage_id' => 'required|exists:stages,id',
        ]);

        $user = Auth::guard('teacher')->user();
        $resource = TeacherResource::where('teacher_id', $user->id)->findOrFail($id);

        $filePath = $resource->file_path;
        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('resources', 'public');
        }

        $imagePath = $resource->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('resources/images', 'public');
        }

        $resource->update([
            'stage_id' => $request->stage_id,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath,
            'file_path' => $filePath,
            'type' => 'pdf',
        ]);

        return redirect()->route('teacher.resources.index')->with('success', 'Resource updated successfully!');
    }


    public function destroy($id)
    {
        $user = Auth::guard('teacher')->user();
        $resource = TeacherResource::where('teacher_id', $user->id)->findOrFail($id);
        $resource->delete();

        return redirect()->route('teacher.resources.index')->with('success', 'Resource deleted successfully!');
    }
}
