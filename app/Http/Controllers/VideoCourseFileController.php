<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\{ Course, Material, VideoCourseFile};

class VideoCourseFileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function downloadFile(VideoCourseFile $file)
    {
        return Storage::download(Self::filePath($file));
    }
    
    public function viewFile(VideoCourseFile $file)
    {
        return response()->file(storage_path('//app//' . Self::filePath($file)));
    }

    private function filePath(VideoCourseFile $file)
    {
        $full_path = "private/video_course_class_materials/{$file->video_course_class_id}/{$file->name}";

        if (Storage::disk('video_course_class_materials')->exists("/{$file->video_course_class_id}/{$file->name}"))
        {
            return $full_path;
        } else
        {
            return response(404);
        }
    }
}