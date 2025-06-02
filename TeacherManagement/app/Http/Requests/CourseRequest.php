<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'hour_start' => 'required|date_format:H:i',
            'hour_end' => 'required|date_format:H:i|after:hour_start',
            'day' => 'required|date_format:Y-m-d',
            "user_id"=>"required|integer",
            "subject_id"=>"required|integer",
            "classroom_id"=>"required|integer",

        ];
    }

    public function message(){
        return [
            'day.date_format'=>'format de date incorect (Y-M-D)',
            'hour_start.date_format'=>'format d\'heure invalide', 
            'hour_start.date_format'=>'format d\'heure invalide', 
            'hour_start.after'=>'l\'heure de fin doit etre superieure a l\'heure de debut', 
            'user_id.required'=>'l\'enseignant  doit etre renseigne',
            'subject_id.required'=>'la matiere doit etre renseigne',
            'classroom_id.required'=>'la classe doit etre renseigne',
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422));
    }
}
