<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function __invoke($file)
    {
        $file = storage_path("files/{$file}");

        if (!Storage::exists($file)) {
            return response('File not found', 404);
        }

        return response()->file($file);
    }
}
