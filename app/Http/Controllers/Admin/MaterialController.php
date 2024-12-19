<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Material;
use App\Models\Stage;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = Material::all();
        return view("admin.material.index", compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stages = Stage::all();
        $images = Image::all();
        return view("admin.material.create", compact('stages', 'images'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'stage_id' => 'required|exists:stages,id',
    //         'image' => 'required|image|mimes:jpeg,png,jpg,gif',
    //         'file_path' => 'required|file|mimes:zip,pdf,docx', 
    //         'how_to_use' => 'required|file|mimes:zip,pdf,docx', 
    //         'learning' => 'required|file|mimes:zip,pdf,docx',
    //         'is_active' => 'nullable|boolean',
    //     ]);

    //     // Handle image upload
    //     $imagePath = null;
    //     if ($request->hasFile('image')) {
    //         $imagePath = $request->file('image')->store('materials', 'public');
    //     }


    //     // Handle file_path (Ebook or zip file handling)
    //     $filePath = null;
    //     $file = $request->file('file_path');
    //     $isZip = $file->getClientOriginalExtension() === 'zip';

    //     if ($isZip) {
    //         $filePath = $file->store('ebooks', 'public');
    //         $extractPath = storage_path('app/public/ebooks/' . pathinfo($filePath, PATHINFO_FILENAME));

    //         $zip = new \ZipArchive;
    //         if ($zip->open(storage_path('app/public/' . $filePath)) === TRUE) {
    //             $zip->extractTo($extractPath);
    //             $zip->close();

    //             $filePath = 'ebooks/' . pathinfo($filePath, PATHINFO_FILENAME);

    //             // Check if the extracted zip contains index.html
    //             if (!file_exists(public_path('storage/' . $filePath . '/index.html'))) {
    //                 return back()->withErrors(['file_path' => 'The extracted zip does not contain index.html.']);
    //             }
    //         } else {
    //             return back()->withErrors(['file_path' => 'Failed to extract the zip file.']);
    //         }
    //     } else {
    //         // For non-zip files
    //         $filePath = $file->store('ebooks', 'public');
    //     }

    //     // Handle how_to_use file upload
    //     $howToUsePath = null;
    //     if ($request->hasFile('how_to_use')) {
    //         $howToUsePath = $request->file('how_to_use')->store('ebooks', 'public');
    //     }

    //     // Handle learning outcomes file upload
    //     $learningPath = null;
    //     if ($request->hasFile('learning')) {
    //         $learningPath = $request->file('learning')->store('ebooks', 'public');
    //     }

    //     // Create a new material with the uploaded data
    //     Material::create([
    //         'title' => $request->title,
    //         'stage_id' => $request->stage_id,
    //         'image' => $imagePath,
    //         'is_active' => $request->is_active ?? 0,
    //         'file_path' => $filePath, // Save the file_path (info) to the material
    //         'how_to_use' => $howToUsePath, // Save how_to_use file path
    //         'learning' => $learningPath, // Save learning outcomes file path
    //     ]);

    //     return redirect()->back()->with('success', 'Theme created successfully.');
    // }
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'stage_id' => 'required|exists:stages,id',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
    //         'existing_image' => 'nullable|string',
    //         'file_path' => 'required',
    //         // 'file_path' => 'required|file|mimes:zip,pdf,ppt,pptx,doc,docx,html,txt|max:10240',
    //         'how_to_use' => 'required',
    //         // 'how_to_use' => 'required|file|mimes:zip,pdf,ppt,pptx,doc,docx,html,txt|max:10240',
    //         'learning' => 'required',
    //         // 'learning' => 'required|file|mimes:zip,pdf,ppt,pptx,doc,docx,html,txt|max:10240',
    //         'is_active' => 'nullable|boolean',
    //     ]);

    // // dd($request->all());
    //     // Handle image upload or existing image
    //     $imagePath = $request->hasFile('image') 
    //         ? $request->file('image')->store('materials', 'public') 
    //         : $request->existing_image;

    //     // Handle file_path upload
    //     // $filePath = $this->handleFileUpload($request->file('file_path'), 'ebooks');
    //     // if ($filePath === false) {
    //     //     return back()->withErrors(['file_path' => 'Failed to extract the zip file or missing index.html.']);
    //     // }

    //     // Handle how_to_use file upload
    //     // $howToUsePath = $this->handleFileUpload($request->file('how_to_use'), 'ebooks');
    //     // if ($howToUsePath === false) {
    //     //     return back()->withErrors(['how_to_use' => 'Failed to extract the zip file or missing index.html.']);
    //     // }

    //     // Handle learning outcomes file upload
    //     // $learningPath = $this->handleFileUpload($request->file('learning'), 'ebooks');
    //     // if ($learningPath === false) {
    //     //     return back()->withErrors(['learning' => 'Failed to extract the zip file or missing index.html.']);
    //     // }



    //     // Create new material
    //     $material = Material::create([
    //         'title' => $request->title,
    //         'stage_id' => $request->stage_id,
    //         'image' => $imagePath,
    //         'is_active' => $request->is_active ?? 0,
    //         'file_path' => $request->file_path,
    //         'how_to_use' => $request->how_to_use,
    //         'learning' => $request->learning,
    //     ]);
    // // dd($material);
    //     return redirect()->back()->with('success', 'Theme created successfully.');
    // }

    public function store(Request $request)
    {
        // Validate the request with named error bag for material form
        $validator = \Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'stage_id' => 'required|exists:stages,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'existing_image' => 'nullable|string',
            'file_path' => 'required',
            'how_to_use' => 'required',
            'learning' => 'required',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            // Return validation errors for the material form only
            return redirect()->back()
                ->withErrors($validator, 'material')
                ->withInput();
        }

        // Handle image upload or existing image
        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('materials', 'public')
            : $request->existing_image;

        // Create new material
        $material = Material::create([
            'title' => $request->title,
            'stage_id' => $request->stage_id,
            'image' => $imagePath,
            'is_active' => $request->is_active ?? 0,
            'file_path' => $request->file_path,
            'how_to_use' => $request->how_to_use,
            'learning' => $request->learning,
        ]);

        return redirect()->back()->with('success', 'Theme created successfully.');
    }

    private function handleFileUpload($file, $storageFolder)
    {
        // Check if ZipArchive is available
        if (!class_exists('ZipArchive')) {
            return false; // Return false if ZipArchive is not installed
        }

        if ($file->getClientOriginalExtension() === 'zip') {
            $storedPath = $file->store($storageFolder, 'public');
            $extractPath = storage_path('app/public/' . $storageFolder . '/' . pathinfo($storedPath, PATHINFO_FILENAME));

            // Ensure that the directory has write permissions
            if (!is_writable(dirname($extractPath))) {
                return false; // Return false if the directory is not writable
            }

            $zip = new \ZipArchive;
            if ($zip->open(storage_path('app/public/' . $storedPath)) === TRUE) {
                if (!$zip->extractTo($extractPath)) {
                    $zip->close();
                    return false; // Return false if extraction fails
                }
                $zip->close();

                // Construct the path to the extracted folder
                $extractedPath = $storageFolder . '/' . pathinfo($storedPath, PATHINFO_FILENAME);
                if (!file_exists(public_path('storage/' . $extractedPath . '/index.html'))) {
                    return false; // Return false if index.html is missing
                }

                return $extractedPath;
            } else {
                return false; // Return false if unable to open ZIP file
            }
        } else {
            return $file->store($storageFolder, 'public'); // Return the stored path if not a zip file
        }
    }



    //     private function handleFileUpload($file, $storageFolder)
    //     {
    //       if ($file->getClientOriginalExtension() === 'zip') {
    //             $storedPath = $file->store($storageFolder, 'public');
    //             $extractPath = asset('/' . $storageFolder . '/' . pathinfo($storedPath, PATHINFO_FILENAME));
    //             mkdir('public/ebooks/'.$file, 0777);
    //             $zip = new \ZipArchive;
    // dd($storedPath,$extractPath,asset('/' . $storedPath),$zip->open(asset('/' . $storedPath)));
    //             if ($zip->open(asset('/' . $storedPath)) === TRUE) {
    //                 $zip->extractTo($extractPath);
    //                 $zip->close();

    //                 $extractedPath = $storageFolder . '/' . pathinfo($storedPath, PATHINFO_FILENAME);
    //                 if (!file_exists(public_path('/' . $extractedPath . '/index.html'))) {
    //                     return false;
    //                 }
    //                 return $extractedPath;
    //             } else {
    //                 return false;
    //             }
    //         } else {
    //             return $file->store($storageFolder, 'public');
    //         }
    //     }


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
        $material = Material::findOrFail($id);
        // dd($material->file_path);
        $stages = Stage::all();
        return view("admin.material.edit", compact('material', 'stages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $material = Material::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'stage_id' => 'required|exists:stages,id',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('materials', 'public');

            $material->image = $imagePath;
        }

        // Update the material
        $material->update([
            'title' => $request->title,
            'stage_id' => $request->stage_id,
            'file_path' => $request->file_path,
            'how_to_use' => $request->how_to_use,
            'learning' => $request->learning,
            'is_active' => $request->is_active ?? 0,
        ]);

        return redirect()->route('material.index')->with('success', 'Theme updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return redirect()->route('material.index')->with('success', 'Theme deleted successfully.');
    }
}
