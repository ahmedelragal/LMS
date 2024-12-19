<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Material;
use App\Models\Unit;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chapters = Chapter::with(['unit', 'material.stage'])->paginate(20);
        return view('admin.chapters.index', compact('chapters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = Unit::all();
        $materials = Material::with('stage')->get();
        return view('admin.chapters.create', compact('units', 'materials'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'unit_id' => 'required|exists:units,id',
    //         'material_id' => 'required|exists:materials,id',
    //         'image' => 'nullable|mimes:jpeg,png,jpg,gif',
    //         'is_active' => 'nullable|boolean',
    //     ]);


    //     $imagePath = null;
    //     if ($request->hasFile('image')) {
    //         $imagePath = $request->file('image')->store('chapters', 'public');
    //     } elseif ($request->existing_image) {
    //         $imagePath = $request->existing_image;
    //     }

    //     Chapter::create([
    //         'title' => $request->title,
    //         'unit_id' => $request->unit_id,
    //         'material_id' => $request->material_id,
    //         'image' => $imagePath,
    //         'is_active' => $request->is_active ?? 0,
    //     ]);

    //     return redirect()->back()->with('success', 'Chapter created successfully.');
    // }

    public function store(Request $request)
    {
        // Custom error bag for chapter form
        $validator = \Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
            'material_id' => 'required|exists:materials,id',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            // Redirect back with validation errors for the chapter form specifically
            return redirect()->back()
                ->withErrors($validator, 'chapter')
                ->withInput();
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chapters', 'public');
        } elseif ($request->existing_image) {
            $imagePath = $request->existing_image;
        }

        Chapter::create([
            'title' => $request->title,
            'unit_id' => $request->unit_id,
            'material_id' => $request->material_id,
            'image' => $imagePath,
            'is_active' => $request->is_active ?? 0,
        ]);

        return redirect()->back()->with('success', 'Chapter created successfully.');
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
        $chapter = Chapter::findOrFail($id);
        $units = Unit::all();
        $materials = Material::all(); // Fetch materials
        return view('admin.chapters.edit', compact('chapter', 'units', 'materials'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $chapter = Chapter::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
            'material_id' => 'required|exists:materials,id', // Validate material
            'image' => 'nullable|mimes:jpeg,png,jpg,gif',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chapters', 'public');
            $chapter->image = $imagePath;
        }

        $chapter->update([
            'title' => $request->title,
            'unit_id' => $request->unit_id,
            'material_id' => $request->material_id, // Update material ID
            'is_active' => $request->is_active ?? 0,
        ]);

        return redirect()->route('chapters.index')->with('success', 'Chapter updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $chapter = Chapter::findOrFail($id);
        $chapter->delete();
        return redirect()->route('chapters.index')->with('success', 'Chapter deleted successfully.');
    }
}
