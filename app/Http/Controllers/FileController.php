<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use App\Services\PdfService;

class FileController extends Controller
{
    protected $pdfService;

    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $file = $request->file('file');

        if (!$this->pdfService->searchFor('Proposal', $file)) {
            return response()->json(['error' => 'The file does not contain the word "Proposal"'], 422);
        }

        $fileName = $file->getClientOriginalName();
        $fileSize = $file->getSize();

        $existingFile = File::where('name', $fileName)->where('size', $fileSize)->first();

        if ($existingFile) {
            $existingFile->update(['updated_at' => now()]);
        } else {
            File::create([
                'name' => $fileName,
                'size' => $fileSize,
            ]);
        }

        $file->storeAs('uploads', $fileName);

        return response()->json(['message' => 'File uploaded successfully']);
    }
}