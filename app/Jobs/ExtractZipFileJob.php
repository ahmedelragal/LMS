<?php

namespace App\Jobs;

use App\Models\Material;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use ZipArchive;

class ExtractZipFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $materialId;
    protected $field;
    protected $filePath;
    /**
     * Create a new job instance.
     */
    public function __construct($materialId, $field, $filePath)
    {
        $this->materialId = $materialId;
        $this->field = $field;
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $material = Material::find($this->materialId);
        if (!$material) {
            return;
        }

        $storagePath = storage_path('app/public/' . $this->filePath);
        $extractPath = storage_path('app/public/ebooks/' . pathinfo($this->filePath, PATHINFO_FILENAME));

        if (pathinfo($this->filePath, PATHINFO_EXTENSION) === 'zip') {
            $zip = new ZipArchive;
            if ($zip->open($storagePath) === TRUE) {
                $zip->extractTo($extractPath);
                $zip->close();

                $extractedPath = 'ebooks/' . pathinfo($this->filePath, PATHINFO_FILENAME);

                // Check if the extracted zip contains index.html
                if (file_exists(public_path('storage/' . $extractedPath . '/index.html'))) {
                    // Update the material record with the extracted path
                    $material->update([$this->field => $extractedPath]);
                }
            }
        }
    }
}
