<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\{VideoCourse, VideoCourseClass, VideoCourseModule};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\{Auth, DB, Storage, Http};

class VideoCourseClassService
{
    public static function getAllVideoCourses(): Collection
    {
        return VideoCourse::all();
    }

    public static function getVideoCourseById(int $id): VideoCourse
    {
        return VideoCourse::find($id);
    }

    public static function getVideoClassData(VideoCourseClass $class): Array
    {
        return [
            'id' => $class->id,
            'original_title' => $class->original_title,
            'furigana_title' => $class->furigana_title,
            'translated_title' => $class->translated_title,
            'link' => $class->embedurl,
            'description' => $class->description_formatted,
            'video_course' => [
                'id' => $class->module->videoCourse->id,
                'title' => $class->module->videoCourse->title,
            ],
            'teacher' => $class->teacher,
            'files' => $class->files,
            'is_done' => $class->viewed,
            'prev_class_link' => self::getPrevClassLink($class),
            'next_class_link' => self::getNextClassLink($class),
            'is_last_of_module' => $class->is_last_of_module
        ];
    }

    public static function getPrevClassLink(VideoCourseClass $videoCourseClass): string
    {
        $prevVideoCourseClass = VideoCourseClass::where('video_course_module_id', $videoCourseClass->video_course_module_id)
            ->where('position', $videoCourseClass->position - 1)
            ->first();

        if ($prevVideoCourseClass) {
            return route('video-courses.classes.show', ['video_course' => $videoCourseClass->module->video_course_id, 'class' => $prevVideoCourseClass->id]);
        }

        return "";
    }

    public static function getNextClassLink(VideoCourseClass $videoCourseClass): string
    {
        $nextVideoCourseClass = VideoCourseClass::where('video_course_module_id', $videoCourseClass->video_course_module_id)
            ->where('position', $videoCourseClass->position + 1)
            ->whereNotNull('link')
            ->first();

        if ($nextVideoCourseClass) {
            return route('video-courses.classes.show', ['video_course' => $videoCourseClass->module->video_course_id, 'class' => $nextVideoCourseClass->id]);
        }

        $nextVideoCourseModule = VideoCourseModule::where('video_course_id', $videoCourseClass->module->video_course_id)
            ->where('position', $videoCourseClass->module->position + 1)
            ->has('classes')
            ->whereHas('classes', function ($query) {
                $query->whereNotNull('link');
            })
            ->first();

        if ($nextVideoCourseModule) {
            $classId = $nextVideoCourseModule->classes()->first()->id;

            return route('video-courses.classes.show', ['video_course' => $nextVideoCourseModule->video_course_id, 'class' => $classId]);
        }

        return "";
    }

    public static function getNextClassLinkByStudentId(VideoCourse $videoCourse, int $studentId): string
    {
        if (!$videoCourse->classes()->exists()) {
            return "";
        }

        $videoCourseId = $videoCourse->id;
        $firstModule = $videoCourse->modules()->has('classes')->orderBy('position')->first();
        $classId = $firstModule->classes()->orderBy('position')->first()->id;

        $firstModuleWithoutViewedClass = $videoCourse->modules()
            ->whereHas('classes', function (Builder $query) use ($studentId) {
                $query->whereDoesntHave('videoCourseClassViews', function (Builder $query) use ($studentId) {
                    $query->where('student_id', $studentId);
                });
            })
            ->orderBy('position')
            ->first();

        $classToRedirect = $firstModuleWithoutViewedClass?->classes()
            ->whereDoesntHave('videoCourseClassViews', function (Builder $query) use ($studentId) {
                $query->where('student_id', $studentId);
            })
            ->orderBy('position')
            ->first();

        if ($classToRedirect) {
            $classId = $classToRedirect->id;
        }

        return route('video-courses.classes.show', ['video_course' => $videoCourseId, 'class' => $classId]);

        if ($classesViewedByUserQuery->exists()) {
            // dd('1');
            $lastClassViewed = $classesViewedByUserQuery
                ->whereHas('module', function ($query) {
                    $query->orderBy('position');
                })
                ->orderBy('position')
                ->first();

            $isTheLastClassOfModule = $lastClassViewed->position === VideoCourseClass::where('video_course_module_id', $lastClassViewed->video_course_module_id)->count();

            if ($isTheLastClassOfModule) {

                $isTheLastModuleOfCourse = $lastClassViewed->module->position === $videoCourse->modules()->count();

                $classId = VideoCourseModule::where('video_course_id', $videoCourseId)
                    ->has('classes')
                    ->where('position', '>', $lastClassViewed->module->position)
                    ->first()
                    ->classes()
                    ->orderBy('position')
                    ->first()
                    ->id;

                if ($isTheLastModuleOfCourse) {
                    return "";
                }
            } else {
                $classId = VideoCourseClass::where('video_course_module_id', $lastClassViewed->video_course_module_id)
                    ->where('position', $lastClassViewed->position + 1)
                    ->first()
                    ->id;
            }
        }

        return route('video-courses.classes.show', ['video_course' => $videoCourseId, 'class' => $classId]);
    }

    public static function storeClass(array $classData): VideoCourseClass
    {
        if (!isset($classData['thumbnail']) || !$classData['thumbnail']) {
            $classData['thumbnail'] = self::getAutoThumbnail($classData['link']);
        } else {
            $classData['thumbnail'] = self::uploadThumbnail($classData);
        }

        if (isset($classData['duration'])) {
            $duration = explode(':', $classData['duration']);
            $greaterThanOrEqualToOneHour = count($duration) === 3;
            $classData['duration'] = $greaterThanOrEqualToOneHour ? $classData['duration'] : "00:{$duration[0]}:{$duration[1]}";
        }

        $classData['position'] = self::getLastPositionByVideoCourseModuleId($classData['video_course_module_id']) + 1;

        return VideoCourseClass::create($classData);
    }

    public static function updateClass(VideoCourseClass $class, array $classData): void
    {
        if(isset($classData['thumbnail'])){
            if($class->thumbnail !== null && $class->thumbnail !== 'default_thumbnail.png') {
                deleteFile($class->getRawOriginal('thumbnail'));
            }
            $classData['thumbnail'] = Self::uploadThumbnail($classData);
        };

        $class->update($classData);
    }

    public static function deleteClass(VideoCourseClass $class): void
    {
        $class->files()->delete();
        $class->delete();
    }

    public static function addStudent(VideoCourse $videoCourse, int $studentId): void
    {
        $videoCourse->students()->attach($studentId);
    }

    public static function removeStudent(VideoCourse $videoCourse, int $studentId): void
    {
        $videoCourse->students()->detach($studentId);
    }

    public static function reorderPositions(array $ids): void
    {
        foreach ($ids as $key => $id) {
            VideoCourseClass::findOrFail($id)->update([
                'position' => $key + 1
            ]);
        }
    }

    private static function getLastPositionByVideoCourseModuleId(int $videoCourseModuleId): int
    {
        return VideoCourseClass::where('video_course_module_id', $videoCourseModuleId)
            ->orderByDesc('position')
            ->first()
            ->position ?? 0;
    }

    public static function uploadThumbnail($request)
    {
        if(!isset($request['thumbnail'])){
            return 'thumbnails/default_thumbnail.png';
        };

        if ($request['thumbnail']) {
            $fileName = uniqid(date('HisYmd')) . ".{$request['thumbnail']->extension()}";

            Storage::putFileAs(
                'public/thumbnails', $request['thumbnail'], $fileName
            );

            return 'thumbnails/' . $fileName;
        } else {
            return 'thumbnails/default_thumbnail.png';
        }
    }

    /**
     * Gera automaticamente a URL da thumbnail de um vídeo baseado no link fornecido.
     * Suporta vídeos do YouTube e Vimeo.
     * 
     * @param string $link URL do vídeo (YouTube ou Vimeo)
     * @return string URL da thumbnail ou caminho para thumbnail padrão
     * @since 08/07/2025
     */
    public static function getAutoThumbnail(string $link): string
    {
        if (str_contains($link, 'youtube.com') || str_contains($link, 'youtu.be')) {
            preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/', $link, $matches);
            $videoId = $matches[1] ?? null;
            return $videoId ? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg" : 'thumbnails/default_thumbnail.png';
        }

        if (str_contains($link, 'vimeo.com')) {
            preg_match('/vimeo\.com\/(\d+)/', $link, $matches);
            $videoId = $matches[1] ?? null;
            if ($videoId) {
                try {
                    $response = Http::get("https://vimeo.com/api/v2/video/{$videoId}.json");
                    if ($response->successful()) {
                        return $response->json()[0]['thumbnail_large'] ?? 'thumbnails/default_thumbnail.png';
                    }
                } catch (\Throwable $e) {
                    
                }
            }
        }

        return 'thumbnails/default_thumbnail.png';
    }
}
