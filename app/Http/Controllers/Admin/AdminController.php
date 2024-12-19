<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Chapter;
use App\Models\Group;
use App\Models\Lesson;
use App\Models\Material;
use App\Models\School;
use App\Models\SchoolType;
use App\Models\Stage;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Type;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {

        $totalSchools = School::count();
        $totalTeachers = Teacher::count();
        $totalStudents = Student::count();

        return view('admin.dashboard', compact('totalSchools', 'totalTeachers', 'totalStudents'));
    }
    public function index()
    {
        $schools = School::paginate(10);
        return view('admin.admins.index', compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stages = Stage::all();
        $themes = Material::all();
        $types = Type::get();

        return view('admin.admins.create', compact('stages', 'themes', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'address' => 'nullable|string|max:255',
        //     'city' => 'nullable|string|max:255',
        //     'type_id' => 'required|exists:types,id',
        // ]);


        // $school = School::create([
        //     'name' => $request->name,
        //     'is_active' => 1,
        //     'address' => $request->address,
        //     'city' => $request->city,
        //     'type_id' => $request->type_id,
        // ]);


        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'type_id' => 'required|exists:types,id',
            'stage_id' => 'required|array', // Ensure stage_id is an array
            'stage_id.*' => 'exists:stages,id', // Ensure each stage ID exists in stages table
            'classes' => 'required|array', // Ensure classes is an array
            'classes.*.name' => 'required|string|max:255', // Validate each class name
            'classes.*.stage_id' => 'required|exists:stages,id', // Validate each class's stage_id
        ]);

        // Create the school
        $school = School::create([
            'name' => $request->name,
            'is_active' => 1,
            'address' => $request->address,
            'city' => $request->city,
            'type_id' => $request->type_id,
        ]);

        // Create classes for this school
        foreach ($request->input('classes') as $class) {
            Group::create([
                'name' => $class['name'],
                'school_id' => $school->id,
                'stage_id' => $class['stage_id'], // Each class has its own stage_id
            ]);
        }

        // Create stages for this school
        $school->stages()->sync($request->input('stage_id'));

        // foreach ($request->input('stage_id') as $stageId) {
        //     School::create([
        //         'school_id' => $school->id,
        //         'stage_id' => $stageId,
        //     ]);
        // }



        // Admin::create([
        //     'name' => $request->admin_name,
        //     'email' => $request->admin_email,
        //     'password' => Hash::make($request->admin_password),
        //     'role' => 'school_admin',
        //     'school_id' => $school->id, // Assign the newly created school ID
        // ]);

        return redirect()->route('admins.index')->with('success', 'School created successfully.');
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
    public function edit($id)
    {
        $school = School::findOrFail($id);
        $types = Type::all();
        $classes = Group::where('school_id', $id)->get();
        $stages = Stage::all();
        // $schoolStages = $school->stages()->pluck('id')->toArray();


        return view('admin.admins.edit', compact('school', 'types', 'classes', 'stages'));
    }



    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, $id)
    {
        $school = School::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'type_id' => 'required|exists:types,id',
            'stage_id' => 'nullable|array',
            'stage_id.*' => 'exists:stages,id',
            'classes' => 'required|array',
            'classes.*.name' => 'required|string|max:255',
            'classes.*.stage_id' => 'required|exists:stages,id',
        ]);

        $school->update([
            'name' => $request->name,
            'address' => $request->address,
            'city' => $request->city,
            'type_id' => $request->type_id,
            'is_active' => $request->is_active ?? 0,
        ]);

        $school->stages()->sync($request->stage_id);

        $classIds = [];

        foreach ($request->classes as $classData) {
            if (isset($classData['id'])) {
                $class = Group::find($classData['id']);
                if ($class) {
                    $class->update([
                        'name' => $classData['name'],
                        'stage_id' => $classData['stage_id'],
                    ]);
                    $classIds[] = $class->id;
                }
            } else {
                $newClass = Group::create([
                    'name' => $classData['name'],
                    'school_id' => $school->id,
                    'stage_id' => $classData['stage_id'],
                ]);
                $classIds[] = $newClass->id;
            }
        }

        if ($request->has('removed_classes')) {
            foreach ($request->removed_classes as $classId) {
                Student::where('class_id', $classId)->update(['class_id' => null]);
                Group::find($classId)?->delete();
            }
        }

        return redirect()->route('admins.index')->with('success', 'School updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $school = School::findOrFail($id);
        $school->delete();

        return redirect()->route('admins.index')->with('success', 'School deleted successfully.');
    }

    public function viewCurriculum($schoolId)
    {
        $school = School::findOrFail($schoolId);

        // Get all stages for the school
        $stages = $school->stages()->with([
            'materials' => function ($query) use ($schoolId) {
                $query->whereHas('schools', function ($q) use ($schoolId) {
                    $q->where('school_id', $schoolId);
                });
            },
            'materials.units' => function ($query) use ($schoolId) {
                $query->whereHas('schools', function ($q) use ($schoolId) {
                    $q->where('school_id', $schoolId);
                });
            },
            'materials.units.chapters' => function ($query) use ($schoolId) {
                $query->whereHas('schools', function ($q) use ($schoolId) {
                    $q->where('school_id', $schoolId);
                });
            },
            'materials.units.chapters.lessons' => function ($query) use ($schoolId) {
                $query->whereHas('schools', function ($q) use ($schoolId) {
                    $q->where('school_id', $schoolId);
                });
            },
        ])->get();

        return view('admin.schools.view_curriculum', compact('school', 'stages'));
    }
    public function assignCurriculum($schoolId)
    {
        $school = School::findOrFail($schoolId);

        $stages = Stage::whereIn('id', function ($query) use ($schoolId) {
            $query->select('stage_id')
                ->from('school_stage')
                ->where('school_id', $schoolId);
        })->get();

        return view('admin.schools.curriculum', compact('school', 'stages'));
    }

    // public function storeCurriculum(Request $request, $schoolId)
    // {
    //     $school = School::findOrFail($schoolId);
    //     $request->validate([
    //         'stage_id' => 'required|exists:stages,id',
    //         'material_id' => 'required|array',
    //         'material_id.*' => 'exists:materials,id',
    //     ]);
    //     $stageId = $request->stage_id;
    //     $materialIds = $request->material_id;
    //     $isStageAssigned = $school->stages()->wherePivot('stage_id', $stageId)->exists();
    //     if (!$isStageAssigned) {
    //         $school->stages()->attach($stageId);
    //     }
    //     foreach ($materialIds as $materialId) {
    //         $isMaterialAssigned = $school->materials()->wherePivot('material_id', $materialId)->exists();

    //         if (!$isMaterialAssigned) {
    //             $school->materials()->attach($materialId);
    //         }
    //         $units = Unit::where('material_id', $materialId)->get();
    //         foreach ($units as $unit) {
    //             $isUnitAssigned = $school->units()->wherePivot('unit_id', $unit->id)->exists();
    //             if (!$isUnitAssigned) {
    //                 $school->units()->attach($unit->id);
    //             }
    //             $chapters = Chapter::where('unit_id', $unit->id)->get();
    //             foreach ($chapters as $chapter) {
    //                 $isChapterAssigned = $school->chapters()->wherePivot('chapter_id', $chapter->id)->exists();
    //                 if (!$isChapterAssigned) {
    //                     $school->chapters()->attach($chapter->id);
    //                 }
    //                 $lessons = Lesson::where('chapter_id', $chapter->id)->get();

    //                 foreach ($lessons as $lesson) {
    //                     $isLessonAssigned = $school->lessons()->wherePivot('lesson_id', $lesson->id)->exists();

    //                     if (!$isLessonAssigned) {
    //                         $school->lessons()->attach($lesson->id);
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     return redirect()->route('admins.index')->with('success', 'Curriculum assigned successfully.');
    // }


    public function storeCurriculum(Request $request, $schoolId)
    {
        $school = School::findOrFail($schoolId);

        // Validate that stage and material IDs are provided.
        $request->validate([
            'stage_id' => 'required|exists:stages,id',
            'material_id' => 'required|array',
            'material_id.*' => 'exists:materials,id',
        ]);

        // Check if the stage is already assigned, if not, assign it.
        if (!$school->stages()->where('stage_id', $request->stage_id)->exists()) {
            $school->stages()->attach($request->stage_id);
        }

        foreach ($request->material_id as $materialId) {
            // Attach material if not already assigned.
            if (!$school->materials()->where('material_id', $materialId)->exists()) {
                $school->materials()->attach($materialId);
            }

            // Fetch and assign all units related to the material.
            $units = Unit::where('material_id', $materialId)->get();
            foreach ($units as $unit) {
                if (!$school->units()->where('unit_id', $unit->id)->exists()) {
                    $school->units()->attach($unit->id);
                }

                // Fetch and assign only chapters related to the unit and material.
                $chapters = Chapter::where('unit_id', $unit->id)
                    ->where('material_id', $materialId) // Ensure material match
                    ->get();

                foreach ($chapters as $chapter) {
                    if (!$school->chapters()->where('chapter_id', $chapter->id)->exists()) {
                        $school->chapters()->attach($chapter->id);
                    }

                    // Fetch and assign lessons related to the chapter.
                    $lessons = Lesson::where('chapter_id', $chapter->id)->get();
                    foreach ($lessons as $lesson) {
                        if (!$school->lessons()->where('lesson_id', $lesson->id)->exists()) {
                            $school->lessons()->attach($lesson->id);
                        }
                    }
                }
            }
        }

        return redirect()->route('admins.index')->with('success', 'Curriculum assigned successfully.');
    }





    public function removeStage($schoolId, $stageId)
    {
        $school = School::findOrFail($schoolId);

        $stage = $school->stages()->find($stageId);

        if ($stage) {
            $stage->materials()->each(function ($material) use ($school) {
                $this->removeMaterial($school->id, $material->id);
            });

            $school->stages()->detach($stageId);
        }

        return redirect()->back()->with('success', 'Stage and its related curriculum removed successfully.');
    }

    public function removeMaterial($schoolId, $materialId)
    {
        $school = School::findOrFail($schoolId);

        $material = $school->materials()->find($materialId);

        if ($material) {
            $material->units()->each(function ($unit) use ($school) {
                $this->removeUnit($school->id, $unit->id);
            });

            $school->materials()->detach($materialId);
        }

        return redirect()->back()->with('success', 'Material and its related curriculum removed successfully.');
    }

    public function removeUnit($schoolId, $unitId)
    {
        $school = School::findOrFail($schoolId);

        $unit = $school->units()->find($unitId);

        if ($unit) {
            $unit->chapters()->each(function ($chapter) use ($school) {
                $this->removeChapter($school->id, $chapter->id);
            });

            $school->units()->detach($unitId);
        }

        return redirect()->back()->with('success', 'Unit and its related curriculum removed successfully.');
    }

    public function removeChapter($schoolId, $chapterId)
    {
        $school = School::findOrFail($schoolId);

        $chapter = $school->chapters()->find($chapterId);

        if ($chapter) {
            $chapter->lessons()->each(function ($lesson) use ($school) {
                $this->removeLesson($school->id, $lesson->id);
            });

            $school->chapters()->detach($chapterId);
        }

        return redirect()->back()->with('success', 'Chapter and its related curriculum removed successfully.');
    }

    public function removeLesson($schoolId, $lessonId)
    {
        $school = School::findOrFail($schoolId);

        $lesson = $school->lessons()->find($lessonId);

        if ($lesson) {
            $school->lessons()->detach($lessonId);
        }

        return redirect()->back()->with('success', 'Lesson removed successfully.');
    }
}
