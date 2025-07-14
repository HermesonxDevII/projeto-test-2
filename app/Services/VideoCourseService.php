<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\{Student, VideoCourse};
use Illuminate\Database\Eloquent\Collection;

class VideoCourseService
{
    public static function getAllVideoCourses(): Collection
    {
        return VideoCourse::all();
    }

    public static function getTeacherVideoCourses(): Collection
    {
        return VideoCourse::where('teacher_access', true)->get();
    }

    public static function getVideoCourseById(int $id): VideoCourse
    {
        return VideoCourse::find($id);
    }

    public static function getVideoCourseByStudentId(int $studentId): Collection
    {
        return VideoCourse::whereRelation('students', 'students.id', $studentId)->get();
    }

    public static function getVideoCourseProgressByStudentId(VideoCourse $videoCourse, int $studentId): int
    {
        $student = Student::find($studentId);
        $classViewCount = $student->videoCourseClassViews()->whereRelation('module', 'video_course_id', $videoCourse->id)->count();
        $totalClasses = $videoCourse->classes()->count();

        return intval(($classViewCount / $totalClasses) * 100);
    }

    public static function storeVideoCourse(array $videoCourseData): VideoCourse
    {
        return VideoCourse::create($videoCourseData);
    }

    public static function updateVideoCourse(VideoCourse $videoCourse, array $videoCourseData): void
    {
        $videoCourse->update($videoCourseData);
    }

    public static function deleteVideoCourse(VideoCourse $videoCourse): void
    {
        if ($videoCourse->thumbnail) {
            deleteFile($videoCourse->getRawOriginal('thumbnail'));
        }

        if ($videoCourse->cover) {
            deleteFile($videoCourse->getRawOriginal('cover'));
        }

        $videoCourse->delete();
    }

    public static function addStudent(VideoCourse $videoCourse, int $studentId): void
    {
        $videoCourse->students()->syncWithoutDetaching([$studentId]);
    }

    public static function removeStudent(VideoCourse $videoCourse, int $studentId): void
    {
        $videoCourse->students()->detach($studentId);
    }
}
