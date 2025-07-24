<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PreRegistrationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'study_plan' => 'nullable|string|max:255',
            'guardian_name' => 'required|string|max:255',
            'guardian_email' => 'required|email|max:255',
            'guardian_phone' => 'required|string|max:20',
            'zipcode' => 'required|string|max:20',
            'province' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'complement' => 'nullable|string|max:255',
            'japan_time' => 'required|string|max:255',
            'children' => 'required|string|max:255',
            'family_structure' => 'required|string|max:255',
            'family_workers' => 'required|string|max:255',
            'workload' => 'required|string|max:255',
            'speaks_japanese' => 'required|string|max:255',
            'studies_at_home' => 'required|string|max:255',
            'will_return_to_home_country' => 'required|string|max:255',
            'home_language' => 'required|string|max:255',
            'student_name' => 'required|string|max:255',
            'student_class' => 'required|string|max:255',
            'student_language' => 'required|string|max:255',
            'student_japan_arrival' => 'required|string|max:255',
            'student_is_shy' => 'required|string|max:255',
            'student_time_alone' => 'required|string|max:255',
            'student_rotine' => 'nullable|string|max:10000',
            'student_extra_activities' => 'nullable|string|max:10000',
            'student_is_focused' => 'required|string|max:255',
            'student_is_organized' => 'required|string|max:255',
            'student_has_good_memory' => 'required|string|max:255',
            'student_has_a_study_plan' => 'required|string|max:255',
            'student_reviews_exams' => 'required|string|max:255',
            'student_reads' => 'required|string|max:255',
            'student_studies' => 'required|string|max:255',
            'student_watches_tv' => 'nullable|string|max:10000',
            'student_uses_internet' => 'nullable|string|max:10000',
            'student_has_smartphone' => 'required|string|max:255',
            'kokugo_grade' => 'required|string|max:255',
            'shakai_grade' => 'required|string|max:255',
            'sansuu_grade' => 'required|string|max:255',
            'rika_grade' => 'required|string|max:255',
            'eigo_grade' => 'required|string|max:255',
            'student_has_difficult' => 'required|string|max:255',
            'student_difficult_in_class' => 'nullable|string|max:10000',
            'student_frequency_in_support_class' => 'required|string|max:255',
            'student_will_take_entrance_exams' => 'required|string|max:255',
            'student_has_taken_online_classes' => 'required|string|max:255',
            'guardian_expectations' => 'nullable|string|max:10000',
            'guardian_concerns' => 'nullable|string|max:10000',
            'guardian_motivations' => 'nullable|string|max:10000',
            'program' => 'nullable|string|max:10000',
            'program_acronym' => 'nullable|string|max:10000'
        ];
    }

    public function messages()
    {
        return [
            'student_rotine.max' => 'O campo "O que seu filho(a) faz em casa?" não deve exceder :max caracteres.',
            'student_extra_activities.max' => 'O campo "Seu filho(a) faz alguma atividade extracurricular?" não deve exceder :max caracteres.',
            'student_watches_tv.max' => 'O campo "O que seu filho(a) consome de TV?" não deve exceder :max caracteres.',
            'student_uses_internet.max' => 'O campo "O que seu filho(a) consome na internet?" não deve exceder :max caracteres.',
            'student_difficult_in_class.max' => 'O campo "Quais os maiores problemas/dificuldades que seu filho(a) está enfrentando nos estudos da escola japonesa?" não deve exceder :max caracteres.',
            'guardian_expectations.max' => 'O campo "O que precisa acontecer nos estudos do seu filho(a) nos próximos 6 meses para você dizer que valeu a pena investir nas Aulas Semanais da Melis Education?" não deve exceder :max caracteres.',
            'guardian_concerns.max' => 'O campo "Gostaria de compartilhar algum acontecimento ou preocupação?" não deve exceder :max caracteres.',
        ];
    }
}
