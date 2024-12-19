<?php

use App\Http\Controllers\Admin\CurriculumController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\School;
use App\Models\Stage;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('stages/{stageId}/materials', [CurriculumController::class, 'getMaterialsByStage']);
Route::get('materials/{materialId}/units', [CurriculumController::class, 'getUnitsByMaterial']);
Route::get('units/{unitId}/chapters', [CurriculumController::class, 'getChaptersByUnit']);
Route::get('chapters/{chapterId}/lessons', [CurriculumController::class, 'getLessonsByChapter']);
Route::get('schools/{school}/stages', function (School $school) {
            return response()->json($school->stages);
        });

        Route::get('stages/{stage}/students', function (Stage $stage) {
            return response()->json($stage->students);
        });