<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Models\StudentEvaluation;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Jobs\NotifyStartCourseToUsers;
use App\Models\StudentEvaluationValue;
use App\Events\CourseStartNotification;
use App\Http\Requests\ClassroomRequest;
use App\Models\{Classroom, EvaluationModel, Student, Weekday};
use App\Services\{ClassroomService, UserService, CourseService, EvaluationService, ScheduleService, StudentService};
use Carbon\Carbon;

class EvaluationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Classroom $classroom): View
    {
        return view('evaluations.create', compact('classroom'));
    }

    public function store(Request $request, Classroom $classroom)
    {
        $request->validate([
            'date' => 'required|date_format:d/m/Y',
            'title' => 'required|string',
            'content' => 'nullable|string',
            'evaluations' => 'required|array',
            'comments' => 'nullable|array',
        ]);

        $date = Carbon::createFromFormat('d/m/Y', $request->input('date'))->format('Y-m-d');

        $evaluation = Evaluation::create([
            'date' => $date,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'author' => Auth::user()->name,
            'classroom_id' => $classroom->id,
            'evaluation_model_id' => $classroom->evaluation_model_id
        ]);

        foreach ($request->input('evaluations') as $student_id => $parameters) {
            $comment = $request->input("comments.$student_id", null);

            $studentEvaluation = StudentEvaluation::create([
                'evaluation_id' => $evaluation->id,
                'student_id' => $student_id,
                'comment' => $comment,
            ]);

            foreach ($parameters as $parameter_id => $value_id) {
                StudentEvaluationValue::create([
                    'student_evaluation_id' => $studentEvaluation->id,
                    'evaluation_parameter_id' => $parameter_id,
                    'evaluation_value_id' => $value_id,
                ]);
            }
        }

        $evaluationDetails = EvaluationService::fetchEvaluation($evaluation); // todos os dados para usar no show

        notify('Avaliação cadastrada com sucesso!');

        return view('evaluations.show', $evaluationDetails);
        
    }

    public function edit(Classroom $classroom, Evaluation $evaluation)
    {
        $evaluation->load([
            'evaluationModel',
            'studentEvaluations.values.parameter',
            'studentEvaluations.values.value',
        ]);

        $parameters = $evaluation->evaluationModel->parameters;

        $existingEvaluations = [];
        $existingComments = [];

        foreach ($evaluation->studentEvaluations as $studentEvaluation) {
            $student_id = $studentEvaluation->student_id;
            $existingComments[$student_id] = $studentEvaluation->comment;

            foreach ($studentEvaluation->values as $value) {
                $parameter_id = $value->evaluation_parameter_id;
                $evaluation_value_id = $value->evaluation_value_id;
                $existingEvaluations[$student_id][$parameter_id] = $evaluation_value_id;
            }
        }

        return view('evaluations.edit', compact('classroom', 'evaluation', 'parameters', 'existingEvaluations', 'existingComments'));
    }

    public function update(Request $request, Classroom $classroom, Evaluation $evaluation)
    {
        $request->validate([
            'date' => 'required|date_format:d/m/Y',
            'title' => 'required|string',
            'content' => 'nullable|string',
            'evaluations' => 'required|array',
            'comments' => 'nullable|array',
        ]);

        $date = \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('date'))->format('Y-m-d');

        $evaluation->update([
            'date' => $date,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        foreach ($request->input('evaluations') as $student_id => $parameters) {
            $comment = $request->input("comments.$student_id", null);

            $studentEvaluation = StudentEvaluation::updateOrCreate(
                [
                    'evaluation_id' => $evaluation->id,
                    'student_id' => $student_id,
                ],
                [
                    'comment' => $comment,
                ]
            );

            $studentEvaluation->values()->delete();

            foreach ($parameters as $parameter_id => $value_id) {
                StudentEvaluationValue::create([
                    'student_evaluation_id' => $studentEvaluation->id,
                    'evaluation_parameter_id' => $parameter_id,
                    'evaluation_value_id' => $value_id,
                ]);
            }
        }

        notify('Avaliação atualizada com sucesso!');

        return redirect()->route('classrooms.show', $classroom->id)->with('success', 'Avaliações atualizadas com sucesso!');
    }

    public function destroy(Evaluation $evaluation): JsonResponse
    {
        DB::beginTransaction();
        try {
            $evaluation->delete();

            DB::commit();

            return response()->json([
                'icon' => 'success',
                'msg'  => 'Avaliação excluído com sucesso!'
            ], 200);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json([
                'icon' => 'error',
                'msg'  => 'Não foi possível excluir a avaliação solicitada.'
            ], 500);
        }
    }

    public function show(Evaluation $evaluation): View
    {
        $data = EvaluationService::fetchEvaluation($evaluation);

        return view('evaluations.show', $data);
    }
}
