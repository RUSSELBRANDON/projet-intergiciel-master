<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateStudentRequest extends FormRequest
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
            "name"=>"required|string|max:255",
            "email"=>"required|email|unique:users,email|max:255",
            "sex"=>"required|string",
            "address"=>"required|string|max:255",
            "age"=>"required|integer"

            
        ];
    }

    public function messages(){
        return [
            'name.required'=>'le nom est obligatoire',
            'emal.required'=>'l\'email est obligatoire',
            'email.email' => 'le format de l\'email est incorecte',
            'sex.required'=>'le champ sexe est obligatoire',
            'age.required'=>'le champ age est obligatoire',
            'age.integer'=>'l\'age doit etre un nombre',
            'address.required'=>'le champ adresse est obligatoire',
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
