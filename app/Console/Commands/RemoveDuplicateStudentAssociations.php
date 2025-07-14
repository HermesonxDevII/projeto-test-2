<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VideoCourse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RemoveDuplicateStudentAssociations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'video-course:remove-duplicates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove duplicate student associations from student_video_course pivot table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->info('Iniciando a remoção de duplicações nas associações de VideoCourses e Students...');

            $totalDuplicatesRemoved = 0;

            $videoCourses = VideoCourse::all();

            foreach ($videoCourses as $videoCourse) {
                $videoCourseId = $videoCourse->id;

                $duplicateStudentIds = DB::table('student_video_course')
                    ->select('student_id')
                    ->where('video_course_id', $videoCourseId)
                    ->groupBy('student_id')
                    ->havingRaw('COUNT(*) > 1')
                    ->pluck('student_id');

                if ($duplicateStudentIds->isEmpty()) {
                    $this->line("VideoCourse ID {$videoCourseId}: Nenhuma duplicação encontrada.");
                    continue;
                }

                $this->line("VideoCourse ID {$videoCourseId}: Encontrados " . $duplicateStudentIds->count() . " student(s) com duplicações.");

                foreach ($duplicateStudentIds as $studentId) {
                    $duplicateEntries = DB::table('student_video_course')
                        ->where('video_course_id', $videoCourseId)
                        ->where('student_id', $studentId)
                        ->orderBy('id')
                        ->get();

                    if ($duplicateEntries->count() <= 1) {
                        continue;
                    }

                    $entriesToDelete = $duplicateEntries->slice(1);

                    foreach ($entriesToDelete as $entry) {
                        DB::table('student_video_course')->where('id', $entry->id)->delete();
                        $totalDuplicatesRemoved++;
                        $this->line("  - Removida duplicação: ID Pivô {$entry->id} para Student ID {$studentId}.");
                    }
                }
            }

            $this->info("Processo concluído. Total de duplicações removidas: {$totalDuplicatesRemoved}.");

            Log::info("Remoção de duplicações concluída. Total de duplicações removidas: {$totalDuplicatesRemoved}.");

            return 0;
        } catch (\Exception $e) {
            $this->error('Ocorreu um erro durante o processo: ' . $e->getMessage());
            Log::error('Erro no comando RemoveDuplicateStudentAssociations: ' . $e->getMessage());

            return 1;
        }
    }
}
