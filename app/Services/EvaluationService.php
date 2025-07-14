<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\{Course, Schedule, Classroom, Evaluation, Student, StudentEvaluation};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EvaluationService
{
    static public function fetchEvaluation(Evaluation $evaluation)
    {
         $evaluation->load([
            'classroom',
            'evaluationModel',
            'evaluationModel.parameters',
        ]);

        $studentEvaluations = StudentEvaluation::with([
            'student',
            'values.parameter',
            'values.value',
        ])
        ->withExistingStudents()
        ->where('evaluation_id', $evaluation->id)
        ->get();

        $classroom = $evaluation->classroom;

        $parameters = $evaluation->evaluationModel->parameters;

        $existingEvaluations = [];
        $existingComments = [];

        foreach ($studentEvaluations as $studentEvaluation) {
            $student_id = $studentEvaluation->student_id;
            $existingComments[$student_id] = $studentEvaluation->comment;

            foreach ($studentEvaluation->values as $value) {                
                $parameter_id = $value->evaluation_parameter_id;
                $evaluation_value_id = $value->evaluation_value_id;
                $existingEvaluations[$student_id][$parameter_id] = $evaluation_value_id;
            }
        }

        return compact(
            'classroom',
            'evaluation',
            'parameters',
            'existingEvaluations',
            'existingComments',
            'studentEvaluations'
        );
    }
}
