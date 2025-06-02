<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class NoteRequest extends FormRequest
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
            'user_id'=>'required|integer',
            'subject_id'=>'required|integer',
            'exam_id'=>'required|integer',
            'note'=>'required|integer|min:0|max:20'
        ];
    }

    public function messages(){
        return [
            'user_id'=>'renseigner l\'etudiant',
            'subject_id'=>'renseigner la matiere',
            'exam_id'=>'renseigner l\'examen',
            'note.required'=>'la note est obligatoire',
            'note.integer'=>'la note doit etre un entier',
            'note.min'=>'la note minimale est 0',
            'note.required'=>'la note maximale est 20',
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
