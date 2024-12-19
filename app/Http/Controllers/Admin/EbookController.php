<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ebook;
use App\Models\Lesson;
use Illuminate\Http\Request;
use ZipArchive;

class EbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ebooks = Ebook::with('lesson')->get();
        return view('admin.ebooks.index', compact('ebooks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lessons = Lesson::all();
        return view('admin.ebooks.create', compact('lessons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'required|file|mimes:zip,pdf,ppt,pptx,doc,docx,html,txt|max:10240', // Accept zip or other file formats
            'lesson_id' => 'required|exists:lessons,id',
        ]);

        // Handle the file upload and saving process
        $file = $request->file('file_path');
        $isZip = $file->getClientOriginalExtension() === 'zip';

        // If it's a zip file, extract it
        if ($isZip) {
            $filePath = $file->store('ebooks', 'public'); // Store the zip file temporarily

            // Create a path for the extracted files
            $extractPath = storage_path('app/public/ebooks/' . pathinfo($filePath, PATHINFO_FILENAME));

            // Extract the zip file
            $zip = new \ZipArchive;
            if ($zip->open(storage_path('app/public/' . $filePath)) === TRUE) {
                $zip->extractTo($extractPath);
                $zip->close();

                // Update the file path to the folder where files are extracted
                $filePath = 'ebooks/' . pathinfo($filePath, PATHINFO_FILENAME);

                // Check if there's an index.html file in the extracted folder
                if (file_exists(public_path('storage/' . $filePath . '/index.html'))) {
                    // Save the ebook record and redirect to view index.html
                    $ebook = Ebook::create([
                        'title' => $request->title,
                        'author' => $request->author,
                        'description' => $request->description,
                        'file_path' => $filePath,
                        'lesson_id' => $request->lesson_id,
                    ]);

                    // Redirect to view the index.html file
                    return redirect()->back();
                }
            } else {
                return back()->withErrors(['file_path' => 'Failed to extract the zip file.']);
            }
        } else {
            // Store non-zip files (pdf, ppt, etc.)
            $filePath = $file->store('ebooks', 'public');
        }

        // Create the Ebook record in the database
        Ebook::create([
            'title' => $request->title,
            'author' => $request->author,
            'description' => $request->description,
            'file_path' => $filePath, // This could be a file or a folder
            'lesson_id' => $request->lesson_id,
        ]);

        return redirect()->route('ebooks.index')->with('success', 'Ebook created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    public function viewEbook(Ebook $ebook)
    {
        // Ensure that $ebook->file_path contains only the relative path
        $relativePath = 'storage/' . $ebook->file_path . '/index.html'; // Correct path for web

        // Construct the URL to the index.html file
        $fileUrl = asset($relativePath); // This creates a public URL

        // Debugging: log the URL
        \Log::info('Looking for index.html at: ' . $fileUrl);

        // Check if the file exists in the storage path
        if (file_exists(public_path($relativePath))) {
            return redirect($fileUrl); // Redirect to the file URL for viewing
        } else {
            return abort(404, 'Index file not found.');
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ebook = Ebook::findOrFail($id);

        $lessons = Lesson::all();

        return view('admin.ebooks.edit', compact('ebook', 'lessons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ebook $ebook)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'nullable|file|mimes:pdf,ppt,pptx,doc,docx,html,txt,zip|max:10240', // Allow multiple types
            'lesson_id' => 'required|exists:lessons,id',
        ]);

        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')->store('ebooks', 'public');
            $ebook->file_path = $filePath;
        }

        $ebook->update([
            'title' => $request->title,
            'author' => $request->author,
            'description' => $request->description,
            'lesson_id' => $request->lesson_id,
        ]);

        return redirect()->route('ebooks.index')->with('success', 'Ebook updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ebook $ebook)
    {
        $ebook->delete();
        return redirect()->route('ebooks.index')->with('success', 'Ebook deleted successfully.');
    }
}
