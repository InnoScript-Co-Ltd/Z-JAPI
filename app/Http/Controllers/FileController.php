<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function download($name)
    {
        $path = "public/uploads/$name";

        $disk = Storage::disk('public/uploads');

        if (! Storage::exists($path)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        return Storage::download($path);

    }
}
