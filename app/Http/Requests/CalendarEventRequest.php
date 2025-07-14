<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalendarEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $isUpdating = $this->has('event_id');

        $rules = [
            'classroom_id' => ['required'],
            'name' => ['required', 'string', 'max: 255'],
            'color' => ['required', 'string', 'min: 4'],
            'start' => ['required'],
            'end' => ['required'],
            'months' => ['required'],
            'repeat' => ['required'],
            'weekdays' => ['nullable'],
            'days' => ['required'],
            'stop_repetition' => ['nullable'],
        ];

        if ($isUpdating) {
            $rules['option'] = ['required'];
            $rules['event_id'] = ['required'];
            $rules['event_day'] = ['required'];
        }

        return $rules;
    }
}
