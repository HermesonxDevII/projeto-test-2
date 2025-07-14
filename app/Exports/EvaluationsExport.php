<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Barryvdh\DomPDF\Facade\Pdf;

class EvaluationsExport implements FromView
{
    protected $data;
    protected $period;
    protected $totalDeliveries;
    protected $totalParticipations;
    protected $totalHomework;
    protected $totalCameraOn;
    protected $evaluationTotal;

    public function __construct($evaluations, $period)
    {
        $this->period = $period;
        $this->totalDeliveries = 0;
        $this->totalParticipations = 0;
        $this->totalHomework = 0;
        $this->totalCameraOn = 0;
        $this->evaluationTotal = 0;
        $this->data = $this->processEvaluations($evaluations);
    }

    public function calculateBehaviour($participacoes, $totalAulas) 
    {
        if ($totalAulas == 0) {
            return "Melhorar";
        }

        $indice = $participacoes / $totalAulas;

        if ($indice >= 1 && $indice < 3) {
            return "Melhorar";
        } elseif ($indice >= 3 && $indice < 5) {
            return "Bom";
        } elseif ($indice >= 5) {
            return "Excelente";
        }
    
        return "Melhorar";

    }

    public function processEvaluations($evaluationsByClassroom)
    {
        $processedData = [];

        foreach($evaluationsByClassroom as $classroomId => $classroomEvaluations) 
        {
            $totalDeliveries = 0;
            $totalParticipations = 0;
            $totalHomework = 0;
            $totalCameraOn = 0;
            $evaluationTotal = 0;
            $comments = [];

            $headings = $classroomEvaluations->first()->evaluation->evaluationModel->parameters->pluck('title')->toArray();

            foreach ($classroomEvaluations as $evaluation) {
                                
                if (isset($evaluation->evaluation->content)) {                    
                    $totalHomework++;
                }

                foreach ($headings as $heading) {
                    $parameter = $evaluation
                        ->evaluation
                        ->evaluationModel
                        ->parameters
                        ->firstWhere('title', $heading);
    
                    if ($parameter) {
                        $value = $evaluation->values->firstWhere('evaluation_parameter_id', $parameter->id);
                        
                        if($value && $value->value) {
                            if ($value->value->title == 'Entregou') {
                                $totalDeliveries++;
                            }
                
                            if ($value->value->title == 'Entrou na hora' || $value->value->title == 'Atraso de 5 minutos') {
                                $totalParticipations++;
                            }
                
                            if ($value->value->title == 'O tempo inteiro on') {
                                $totalCameraOn++;
                            }
                
                            if ($value->value->title == 'Excelente') {
                                $evaluationTotal += 5;
                            }
                
                            if ($value->value->title == 'Bom') {
                                $evaluationTotal += 3;
                            }
                
                            if ($value->value->title == 'Melhorar') {
                                $evaluationTotal += 1;
                            }                     
                        }                        
                    }
                }
                
                if ($evaluation->comment) {
                    $comments[] = nl2br($evaluation->comment);
                }
            }
        
            $processedData[$classroomId] = [
                'student_name' => $evaluation->student->full_name ?? 'Estudante Desconhecido',
                'classroom_name' => $evaluation->evaluation->classroom->name ?? 'Turma desconhecida',
                'period' => $this->period,
                'author' => $evaluation->evaluation->author ?? 'Professor(a) desconhecido',
                'comments' => $comments,
                'evaluation_sum' => $classroomEvaluations->count(),
                'delivery_sum' => $totalDeliveries,
                'sum_homework' => $totalHomework,
                'total_camera_on' => $totalCameraOn,
                'participation_sum' => $totalParticipations,
                'behavior' => $this->calculateBehaviour($evaluationTotal, $classroomEvaluations->count())
            ];
        }

        return $processedData;
    }

    public function view(): View
    {
        return view('exports.students', [
            'datas' => $this->data,
        ]);
    }

    public function generatePdf()
    {
        // Renderiza a view em HTML
        $html = $this->view()->render();

        // Gera o PDF a partir da view renderizada
        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'portrait')->setOption('font', 'ipaexg');

        return $pdf;
    }
}
