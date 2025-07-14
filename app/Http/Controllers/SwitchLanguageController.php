<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SwitchLanguageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'language_id' => ['required', 'exists:languages,id']
        ]);

        $student = selectedStudent();

        if (!$student) {
            return response()->json([
                'msg' => 'Estudante não encontrado.'
            ], 500);
        }

        if ($student->guardian_id !== loggedUser()->id) {
            return response()->json([
                'msg' => 'Responsável não possui permissão para atualizar estudante.'
            ], 500);
        }

        $locale = Language::find($data['language_id'])->short_name;

        if (!$locale || !in_array($locale, ['pt_BR', 'en', 'es', 'jp'])) {
            abort(400);
        }

        $student->update(['system_language_id' => $data['language_id']]);

        session()->forget('lang');

        return response()->json([
            'msg' => 'Idioma do estudante atualizado com sucesso.'
        ]);
    }
}
