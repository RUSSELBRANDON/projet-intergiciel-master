<?php

namespace App\Http\Requests\BorrowRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateLoanRequest extends FormRequest
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
            'lender_id'=>'required|exists:users,id',
            'due_date' => 'required|date|after:today',
        ];
    }

    public function messages(){
        return [
            'lender_id.required'=>'the  field is required',
            'due_date.required'=>'the due date field is required',
            'due_date.date_format'=>'the correct date format is d/m/y',
        ];
    }

    public function failedValidation(Validator $validator){
        return new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
        ],400));
    }

}

