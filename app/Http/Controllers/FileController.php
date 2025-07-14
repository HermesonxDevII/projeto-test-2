<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\{ Course, Material };

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function downloadMaterial(Material $material)
    {
        return Storage::download(Self::materialPath($material));
    }
    
    public function viewMaterial(Material $material)
    {
        return response()->file(storage_path('//app//' . Self::materialPath($material)));
    }

    private function materialPath(Material $material)
    {
        $this->authorize('getMaterial', $material);
        $full_path = "private/course_materials/{$material->course_id}/{$material->file->name}";

        if (Storage::disk('course_materials')->exists("/{$material->course_id}/{$material->file->name}"))
        {
            return $full_path;
        } else
        {
            return response(404);
        }
    }
}