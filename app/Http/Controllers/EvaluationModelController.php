<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\EvaluationModel;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class EvaluationModelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $evaluationModels = EvaluationModel::all();

        return view('evaluation-models.index', compact('evaluationModels'));
    }

    public function create(): View
    {
        return view('evaluation-models.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'parameters' => 'required|array',
            'parameters.*.title' => 'required|string|max:255',
            'parameters.*.required' => 'nullable|boolean',
            'parameters.*.values' => 'required|array',
            'parameters.*.values.*.title' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $evaluationModel = EvaluationModel::create([
                'title' => $request->input('title')
            ]);

            foreach ($request->input('parameters') as $paramData) {
                $parameter = $evaluationModel->parameters()->create([
                    'title' => $paramData['title'],
                    'required' => $paramData['required'] ?? false,
                ]);

                foreach ($paramData['values'] as $valueData) {
                    $parameter->values()->create([
                        'title' => $valueData['title'],
                    ]);
                }
            }

            DB::commit();

            notify('Modelo de avaliação criado com sucesso!');

            return redirect()->route('evaluationModels.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Ocorreu um erro ao salvar o modelo de avaliação: ' . $e->getMessage())->withInput();
        }
    }


    public function show(EvaluationModel $evaluationModel): View
    {
        $evaluationModel->load('parameters.values');

        return view('evaluation-models.show', compact('evaluationModel'));
    }


    public function edit(EvaluationModel $evaluationModel): View
    {
        $evaluationModel->load('parameters.values');
        return view('evaluation-models.edit', compact('evaluationModel'));
    }


    public function update(Request $request, EvaluationModel $evaluationModel)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'parameters' => 'required|array',
            'parameters.*.title' => 'required|string|max:255',
            'parameters.*.required' => 'nullable|boolean',
            'parameters.*.values' => 'required|array',
            'parameters.*.values.*.title' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $evaluationModel->update([
                'title' => $request->input('title'),
            ]);

            $evaluationModel->parameters()->each(function ($parameter) {
                $parameter->values()->delete();
                $parameter->delete();
            });

            foreach ($request->input('parameters') as $paramData) {
                $parameter = $evaluationModel->parameters()->create([
                    'title' => $paramData['title'],
                    'required' => $paramData['required'] ?? false,
                ]);

                foreach ($paramData['values'] as $valueData) {
                    $parameter->values()->create([
                        'title' => $valueData['title'],
                    ]);
                }
            }

            DB::commit();

            notify('Modelo de avaliação atualizado com sucesso!');

            return redirect()->route('evaluationModels.index')->with('success', 'Modelo de avaliação atualizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return back()->withErrors('Ocorreu um erro ao atualizar o modelo de avaliação.')->withInput();
        }
    }


    public function destroy(EvaluationModel $evaluationModel): JsonResponse
    {
        DB::beginTransaction();
        try {
            $evaluationModel->delete();

            DB::commit();

            return response()->json([
                'icon' => 'success',
                'msg'  => 'Modelo excluído com sucesso!'
            ], 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'icon' => 'error',
                'msg'  => $ex->getMessage(),
            ], 500);
        }
    }
}
