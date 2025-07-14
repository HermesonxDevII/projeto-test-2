<?php

namespace App\Http\Controllers;

use App\Models\VideoCourse;
use App\Models\VideoCourseClass;
use App\Services\UserService;
use App\Services\VideoCourseClassService;
use App\Services\VideoCourseModuleService;
use App\Http\Requests\VideoCourseClassRequest;
use App\Services\FileService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class VideoCourseClassController extends Controller
{
    public function create(VideoCourse $videoCourse): View
    {
        if (Gate::denies('admin')) {
            abort(403);
        }

        $teachers = UserService::getTeachers();
        $modules = VideoCourseModuleService::getModulesByVideoCourse($videoCourse);

        return view('video-courses-classes.create', compact('videoCourse', 'teachers', 'modules'));
    }

    public function store(VideoCourseClassRequest $request, VideoCourse $videoCourse): RedirectResponse
    {
        if (Gate::denies('admin')) {
            abort(403);
        }

        $requestData = $request->validated();
        DB::beginTransaction();
        try {
            $class = VideoCourseClassService::storeClass($requestData['class']);

            if (isset($requestData['materials']) && $requestData['materials']) {
                foreach ($requestData['materials'] as $file) {
                    FileService::storeVideoCourseClassMaterial($class, $file);
                }
            }

            DB::commit();
            notify('Aula cadastrada com sucesso!');
            return redirect()->route('video-courses.show', $videoCourse->id);
        } catch (\Exception $ex) {
            DB::rollBack();
            notify('Não foi possível cadastrar a aula.', 'error');
            return back()->withInput();
        }
    }

    public function show(VideoCourse $videoCourse, VideoCourseClass $class): View
    {
        $user = loggedUser();

        if ($user->is_teacher && !$videoCourse->teacher_access) {
            abort(403);
        }

        $module = $class->module;

        if ($user->is_administrator || $user->is_teacher) {
            return view('video-courses-classes.show', compact('videoCourse', 'class', 'module'));
        }

        $student = selectedStudent();

        if ($user->is_guardian && $student) {
            $prevClassLink = VideoCourseClassService::getPrevClassLink($class);
            $nextClassLink = VideoCourseClassService::getNextClassLink($class);
            $progress = VideoCourseModuleService::getModuleProgressByStudentId($module, $student->id);
            $classFinished = $class->viewed;

            return view('video-courses-classes.show', compact('videoCourse', 'class', 'module', 'progress', 'prevClassLink', 'nextClassLink', 'classFinished'));
        }
    }

    public function edit(VideoCourse $videoCourse, VideoCourseClass $class): View
    {
        if (Gate::denies('admin')) {
            abort(403);
        }

        $teachers = UserService::getTeachers();
        $modules = VideoCourseModuleService::getModulesByVideoCourse($videoCourse);

        return view('video-courses-classes.edit', compact('videoCourse', 'class', 'teachers', 'modules'));
    }

    public function update(VideoCourseClassRequest $request, VideoCourse $videoCourse, VideoCourseClass $class): RedirectResponse
    {
        if (Gate::denies('admin')) {
            abort(403);
        }

        $requestData = $request->validated();
        DB::beginTransaction();
        try {
            VideoCourseClassService::updateClass($class, $requestData['class']);

            if (isset($requestData['deleted_files']) && $requestData['deleted_files']) {
                foreach (explode(',', $requestData['deleted_files']) as $file_id) {
                    FileService::deleteVideoCourseClassMaterial($file_id);
                }
            }

            if (isset($requestData['materials']) && $requestData['materials']) {
                foreach ($requestData['materials'] as $file) {
                    FileService::storeVideoCourseClassMaterial($class, $file);
                }
            }

            DB::commit();
            notify('Aula atualizada com sucesso!');
            return redirect()->route('video-courses.show', $videoCourse->id);
        } catch (\Exception $ex) {
            DB::rollBack();
            notify('Não foi possível atualizar a aula.', 'error');
            return back()->withInput();
        }
    }

    public function destroy(VideoCourse $videoCourse, VideoCourseClass $class)
    {
        if (Gate::denies('admin')) {
            abort(403);
        }

        DB::beginTransaction();
        try {
            VideoCourseClassService::deleteClass($class);
            notify('Aula excluída com sucesso!');
            DB::commit();
            return response()->json([
                'icon' => 'success',
                'msg'  => 'Aula excluída com sucesso!'
            ]);
        } catch (\Exception $ex) {
            DB::rollBack();
            notify('Não foi possível excluir a aula solicitada.', 'error');
            return back();
        }
    }

    public function getBasicData(VideoCourseClass $class)
    {
        return $class->toArray();
    }

    public function getVideoClassData(VideoCourseClass $class): array
    {
        return VideoCourseClassService::getVideoClassData($class);
    }

    public function reorderPositions(Request $request)
    {
        if (Gate::denies('admin')) {
            abort(403);
        }

        DB::beginTransaction();
        try {
            VideoCourseClassService::reorderPositions($request->input('orderIds'));

            DB::commit();

            return response()->json([
                'icon' => 'success',
                'msg'  => 'Ordem das aulas alterada com sucesso!'
            ]);
        } catch (\Exception $ex) {
            DB::rollBack();

            return response()->json([
                'icon' => 'error',
                'msg'  => 'Não foi possível alterar a ordem das aulas.'
            ], 500);
        }
    }
}
