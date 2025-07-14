<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\{Course, File, Material, Schedule, VideoCourseClass, VideoCourseFile};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class FileService {
    static public function downloadMaterial(Course $course ,$file) {
        $full_path = "private/course_materials/{$course->id}/{$file}";

        if(Storage::disk('course_materials')->exists("/{$course->id}/$file")) {
            return Storage::download($full_path);
        }
        else {
            return "{$full_path} não encontrado!";
        }
    }

    static private function storeFile(UploadedFile $uploadedFile, string $path = "/uploads"): int
    {
        $file = new File();
        $file->owner_id = Auth::user()->id;
        $file->name = $uploadedFile->getClientOriginalName();
        $file->path = $path;
        $file->save();

        return $file->id;
    }

    static public function storeMaterial(Course $course, UploadedFile $uploadedFile): void
    {
        $fileId = Self::storeFile(
            $uploadedFile,
            "/{$course->id}/{$uploadedFile->getClientOriginalName()}"
        );

        $material = new Material();
        $material->course_id = $course->id;
        $material->file_id = $fileId;
        $material->save();

        Self::uploadMaterial($course, $uploadedFile);
    }

    static public function uploadMaterial(Course $course, UploadedFile $file): void
    {
        $file->storeAs(
            "/{$course->id}",
            $file->getClientOriginalName(),
            "course_materials"
        );
    }

    static public function deleteMaterial($file): void
    {
        // Todo :: policies to verify if the user owns the file before delete
        Material::find($file)->delete();
    }

    public static function uploadPublicFile(UploadedFile $file, string $path): string
    {
        $fileName = uniqid(date('HisYmd')) . ".{$file->extension()}";

        Storage::putFileAs(
            "public/{$path}", $file, $fileName
        );

        return "{$path}/{$fileName}";
    }

    public static function storeVideoCourseClassMaterial(VideoCourseClass $class, UploadedFile $file)
    {
        $path = "/{$class->id}";
        $options = "video_course_class_materials";

        self::uploadPrivateFile(
            file: $file, 
            path: $path, 
            options: $options
        );

        VideoCourseFile::create([
            'name' => $file->getClientOriginalName(),
            'path' => "{$path}/{$file->getClientOriginalName()}",
            'owner_id' => loggedUser()->id,
            'video_course_class_id' => $class->id
        ]);
    }

    public static function deleteVideoCourseClassMaterial($file): void
    {
        // Todo :: policies to verify if the user owns the file before delete
        VideoCourseFile::find($file)->delete();
    }

    public static function uploadPrivateFile(UploadedFile $file, string $path, array|string $options = []): void
    {
        $file->storeAs(
            $path,
            $file->getClientOriginalName(),
            $options
        );
    }
}
