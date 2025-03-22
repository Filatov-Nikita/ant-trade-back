<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileRequest;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\FileResource;

class FileController extends Controller
{
    public function store(StoreFileRequest $request) {
        $path = $request->file('file')->store('files', 'public');
        $fileModel = File::make();
        $fileModel->path = $path;
        $fileModel->disk = 'public';
        $fileModel->size_in_bytes = Storage::disk('public')->size($path);
        $fileModel->mime_type = Storage::disk('public')->mimeType($path);
        $fileModel->save();
        return new FileResource($fileModel);
    }

    public function destroy(File $file) {
        Storage::disk($file->disk)->delete($file->path);
        $file->delete();
    }
}
