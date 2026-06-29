<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class FileController extends Controller
{
    public function __invoke(string $file): Response
    {
        $filePath = storage_path("files/{$file}");

        if (! file_exists($filePath) || ! is_file($filePath)) {
            return response('File not found', 404);
        }

        $realPath = realpath($filePath);
        $basePath = realpath(storage_path('files'));

        if (! $realPath || ! $basePath || ! str_starts_with($realPath, $basePath)) {
            return response('File not found', 404);
        }

        if (app()->environment('testing')) {
            return response(file_get_contents($filePath));
        }

        return response()->file($filePath);
    }
}
