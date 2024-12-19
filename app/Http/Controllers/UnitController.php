<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Material;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index($materialId)
    {
        $userAuth = auth()->guard('student')->user();

        if ($userAuth) {
            // Fetch the material with units and their chapters.
            $material = Material::with([
                'units' => function ($query) {
                    $query->with('chapters');
                }
            ])->findOrFail($materialId);

            // Fetch chapters where both the unit and material match the criteria.
            $chapters = Chapter::whereHas('unit', function ($query) use ($materialId) {
                $query->where('material_id', $materialId); // Ensure the unit belongs to the material.
            })->whereIn('unit_id', $material->units->pluck('id')) // Ensure chapters belong to the units.
                ->where('material_id', $materialId) // Ensure the chapter's material matches the selected material.
                ->get();
            // dd($chapters);

            // Pass the data to the view.
            return view('pages.student.unit.index', compact('material', 'chapters', 'userAuth'));
        } else {
            return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
        }
    }

}
