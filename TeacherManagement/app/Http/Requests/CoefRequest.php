<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CoefRequest extends FormRequest
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
            "classroom_id"=>"required|integer",
            "subject_id"=>"required|integer",
            "coef"=>"required|integer",
        ];
    }

    public function messages(){
        return [
            'coef.required'=>'le coeficient  doit etre renseigne',
            'subject_id.required'=>'la matiere  doit etre renseigne',
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
