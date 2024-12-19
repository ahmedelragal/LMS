<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Ebook;
use App\Models\Lesson;
use App\Models\Unit;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function index($themeId, $unitId)
    {
        $userAuth = auth()->guard('student')->user();

        if ($userAuth) {
            // Fetch the unit with chapters filtered by both theme_id and unit_id
            $unit = Unit::with(['chapters' => function ($query) use ($themeId) {
                $query->where('material_id', $themeId);
            }])->findOrFail($unitId);

            return view('pages.student.chapter.index', compact('unit', 'userAuth'));
        } else {
            return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
        }
    }

    public function showLessons($chapterId)
    {

        $userAuth = auth()->guard('student')->user();
        if ($userAuth) {
            $chapter = Chapter::findOrFail($chapterId);
            return view('pages.student.lesson.index', compact('chapter', 'userAuth'));
        } else {
            return redirect()->route('login')->withErrors(['error' => 'Unauthorized access']);
        }
    }
    public function viewEbooks($lessonId)
    {
        $userAuth = auth()->guard('student')->user();

        // Fetch the lesson along with its related eBooks
        $lesson = Lesson::with('ebooks')->findOrFail($lessonId);

        // Pass the lesson and authenticated user to the view
        return view('pages.student.lesson.ebooks', compact('lesson', 'userAuth'));
    }
    // public function viewEbook(Ebook $ebook)
    // {
    //     // Ensure that $ebook->file_path contains only the relative path
    //     $relativePath = 'storage/' . $ebook->file_path . '/index.html'; // Correct path for web

    //     // Construct the URL to the index.html file
    //     $fileUrl = asset($relativePath); // This creates a public URL

    //     // Debugging: log the URL
    //     \Log::info('Looking for index.html at: ' . $fileUrl);

    //     // Check if the file exists in the storage path
    //     if (file_exists(public_path($relativePath))) {
    //         return redirect($fileUrl); // Redirect to the file URL for viewing
    //     } else {
    //         return abort(404, 'Index file not found.');
    //     }
    // }
}
