<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Lesson;
use App\Models\Material;
use App\Models\Unit;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{

    public function getMaterialsByStage($stageIds)
    {
        $stageIdsArray = explode(',', $stageIds);
        $materials = Material::whereIn('stage_id', $stageIdsArray)->get();
        return response()->json($materials);
    }

    public function getUnitsByMaterial($materialIds)
    {
        $materialIdsArray = explode(',', $materialIds);
        $units = Unit::with('chapters.lessons')
            ->whereIn('material_id', $materialIdsArray)->get();
        return response()->json($units);
    }

    public function getChaptersByUnit($unitIds, $materialId = null)
    {
        $unitIdsArray = explode(',', $unitIds);

        $chapters = Chapter::with('lessons')
            ->whereIn('unit_id', $unitIdsArray)
            ->when($materialId, function ($query) use ($materialId) {
                return $query->where('material_id', $materialId);
            })
            ->get();
        return response()->json($chapters);
    }

    public function getLessonsByChapter($chapterIds)
    {
        $chapterIdsArray = explode(',', $chapterIds);
        $lessons = Lesson::whereIn('chapter_id', $chapterIdsArray)->get();
        return response()->json($lessons);
    }
}
