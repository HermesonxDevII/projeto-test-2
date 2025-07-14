<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateVideoCourseModuleRequest;
use App\Models\{VideoCourse, VideoCourseModule};
use App\Services\VideoCourseModuleService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class VideoCourseModuleController extends Controller
{
    public function create(VideoCourse $videoCourse): View
    {
        if (Gate::denies('admin')) {
            abort(403);
        }

        return view('video-courses-modules.create', compact('videoCourse'));
    }

    public function store(Request $request, VideoCourse $videoCourse)
    {
        if (Gate::denies('admin')) {
            abort(403);
        }

        $requestData = $request->validate([
            'modules' => ['required', 'array'],
            'modules.*' => ['required', 'string']
        ]);
        
        DB::beginTransaction();
        try {
            VideoCourseModuleService::storeModules($requestData['modules'], $videoCourse);

            DB::commit();
            notify('Módulo atualizado com sucesso!');
            return redirect()->route('video-courses.show', $videoCourse->id);
        } catch (\Exception $ex) {
            DB::rollBack();
            notify('Não foi possível atualizar o módulo solicitado.', 'error');
            return back();
        }
    }

    public function edit(VideoCourse $videoCourse, VideoCourseModule $module): View
    {
        if (Gate::denies('admin')) {
            abort(403);
        }

        return view('video-courses-modules.edit', compact('videoCourse', 'module'));
    }

    public function update(UpdateVideoCourseModuleRequest $request, VideoCourse $videoCourse, VideoCourseModule $module)
    {
        if (Gate::denies('admin')) {
            abort(403);
        }

        DB::beginTransaction();
        try {
            VideoCourseModuleService::updateModule($request->validated(), $module);

            DB::commit();
            notify('Módulo atualizado com sucesso!');
            return redirect()->route('video-courses.show', $videoCourse->id);
        } catch (\Exception $ex) {
            DB::rollBack();
            notify('Não foi possível atualizar o módulo solicitado.', 'error');
            return back();
        }
    }

    public function destroy(VideoCourse $videoCourse, VideoCourseModule $module): RedirectResponse
    {
        if (Gate::denies('admin')) {
            abort(403);
        }

        DB::beginTransaction();
        try {
            VideoCourseModuleService::deleteModule($module);

            notify('Módulo excluído com sucesso!');
            DB::commit();

        } catch (\Exception $ex) {
            DB::rollBack();
            notify('Não foi possível excluir o módulo solicitado.', 'error');
            return back();
        }
    }

    public function getBasicData(VideoCourseModule $module)
    {
        return $module->toArray();
    }

    public function reorderPositions(Request $request)
    {
        if (Gate::denies('admin')) {
            abort(403);
        }

        DB::beginTransaction();
        try {
            VideoCourseModuleService::reorderPositions($request->input('orderIds'));

            DB::commit();

            return response()->json([
                'icon' => 'success',
                'msg'  => 'Ordem dos módulos alterado com sucesso!'
            ]);
        } catch (\Exception $ex) {
            DB::rollBack();

            return response()->json([
                'icon' => 'error',
                'msg'  => 'Não foi possível alterar a ordem dos módulos.'
            ], 500);
        }
    }
}
