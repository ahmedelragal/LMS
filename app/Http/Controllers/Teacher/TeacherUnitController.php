<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class TeacherUnitController extends Controller
{
    public function index($materialId)
    {
        $material = Material::with('units')->findOrFail($materialId);
        return view('pages.teacher.units.index', compact('material'));
    }
}
