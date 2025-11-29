<?php

declare(strict_types=1);

namespace App\Http\Controllers;

class FileController extends Controller
{
    public function __invoke($file)
    {
        $filePath = storage_path("files/{$file}");

        if (! file_exists($filePath) || ! is_file($filePath)) {
            return response('File not found', 404);
        }

        // Prevent directory traversal
        $realPath = realpath($filePath);
        $basePath = realpath(storage_path('files'));

        if (! $realPath || ! $basePath || strpos($realPath, $basePath) !== 0) {
            return response('File not found', 404);
        }

        // For testing, return the file content directly
        if (app()->environment('testing')) {
            return response(file_get_contents($filePath));
        }

        return response()->file($filePath);
    }
}
