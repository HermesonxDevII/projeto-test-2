<?php

namespace App\Console\Commands;

use App\Models\Student;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AtualizarGrades extends Command
{
    /**
     * O nome e a assinatura do comando.
     *
     * @var string
     */
    protected $signature = 'atualizar:grades';

    /**
     * A descrição do comando.
     *
     * @var string
     */
    protected $description = 'Atualiza a série (grade) dos alunos de acordo com o mapeamento DE → PARA';

    /**
     * Executa o comando.
     */
    public function handle(): void
    {
        // Mapear os títulos para IDs
        $gradeMap = DB::table('grades')
            ->select('id', 'name')
            ->get()
            ->pluck('id', 'name');

        // Mapeamento de séries DE → PARA

        $migracoes = [
            'Shougakko 2' => 'Shougakko 3', // 8 => 9
            'Shougakko 3' => 'Shougakko 4', // 9 => 1
            'Shougakko 4' => 'Shougakko 5', // 1 => 2
            'Shougakko 5' => 'Shougakko 6', // 2 => 3
            'Shougakko 6' => 'Chugakko 1',  // 3 => 4 
            'Chugakko 1' => 'Chugakko 2',   // 4 => 5 
            'Chugakko 2' => 'Chugakko 3',   // 5 => 6
        ];

        $originalStudents = [];
        foreach ($migracoes as $de => $para) {
            $fromId = $gradeMap[$de] ?? null;
        
            if ($fromId) {
                $originalStudents[$fromId] = DB::table('students')
                    ->where('grade_id', $fromId)
                    ->pluck('id')
                    ->toArray();
            }
        }

        // Aplicar as mudanças
        foreach ($migracoes as $de => $para) {
            $fromId = $gradeMap[$de] ?? null;
            $toId = $gradeMap[$para] ?? null;

            if ($fromId && $toId) {

                $studentsToUpdate = $originalStudents[$fromId] ?? [];

                if (!empty($studentsToUpdate)) {
                    DB::table('students')
                        ->whereIn('id', $studentsToUpdate)
                        ->update(['grade_id' => $toId]);
        
                    $this->info("Atualizados " . count($studentsToUpdate) . " aluno(s) de \"$de\" para \"$para\".");
                } else {
                    $this->info("Nenhum aluno original encontrado para \"$de\".");
                }

            } else {
                $this->warn("Não encontrado: $de ou $para na tabela de grades.");
            }
        }

        $this->info('Atualização de séries finalizada com sucesso!');
    }
}
