<?php

namespace App\Http\Controllers;

use App\Models\SchoolType;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = Type::paginate(10);
        return view('admin.type.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.type.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:types,name',
        ]);


        $type = Type::create([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('types.index')->with('success', 'Type created successfully.');
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
        $types = Type::findOrFail($id);


        return view('admin.type.edit', compact('types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $types = Type::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:types,name',
        ]);

        $types->update([
            'name' => $request->input('name'),

        ]);

        return redirect()->route('types.index')->with('success', 'Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $types = Type::findOrFail($id);
        $types->delete();
        return redirect()->route('types.index')->with('success', 'Type deleted successfully.');
    }
}
