<?php

namespace App\Http\Controllers;

use App\Models\{Classroom, Module}
;use Illuminate\Http\{JsonResponse, RedirectResponse, Request};
use App\Services\{ModuleService};
use Illuminate\Support\Facades\DB;

class ModuleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $this->authorize();
        return back();
    }

    public function create(Classroom $classroom = null)
    {
        return view('modules.create', compact('classroom'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Module::class);
        DB::beginTransaction();
        try {
            $classroom_id = $request->input('classroom_id');

            foreach ($request->input('module') as $key => $value) {
                $module_id = ModuleService::storeModule([
                    'name' => $value,
                    'classroom_id' => $classroom_id,
                    'position' => 0
                ]);
            }

            DB::commit();
            notify('Módulo cadastrado com sucesso!');
        } catch (\Exception $ex) {
            DB::rollBack();
            notify('Não foi possível cadastrar o módulo solicitado.', 'error');
        }
        return redirect()->route('classrooms.recorded-courses', $classroom_id);
    }

    public function show(Module $module)
    {
        //
    }

    public function edit(Module $module)
    {
        $this->authorize('update', $module);

        return view('modules.edit', compact('module'));
    }

    public function update(Request $request, Module $module): RedirectResponse
    {

        $this->authorize('update', $module);

        DB::beginTransaction();
        try {
            ModuleService::updateModule($request->all(), $module);

            DB::commit();
            notify('Módulo atualizado com sucesso!');
            return redirect()->route('classrooms.recorded-courses', $module->classroom->id);
        } catch (\Exception $ex) {
            DB::rollBack();
            notify('Não foi possível atualizar o módulo solicitado.', 'error');
            return back();
        }
    }

    public function destroy(Module $module): RedirectResponse
    {
        $this->authorize('delete', $module);
        DB::beginTransaction();
        try {
            ModuleService::deleteModule($module);

            notify('Módulo excluído com sucesso!');
            DB::commit();

        } catch (\Exception $ex) {
            DB::rollBack();
            notify('Não foi possível excluir o módulo solicitado.', 'error');
            return back();
        }
    }

    public function getBasicData(Module $module)
    {
        return [
            'id' => $module->id,
            'name' => $module->formattedName,
            'position' => $module->position,
            'classroom_id' => $module->id,
            'courses_count' => $module->courses->count()
        ];
    }
}
