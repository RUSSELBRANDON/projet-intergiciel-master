<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SendNotificationRequest extends FormRequest
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
        $rules = [
            'type' => 'required|in:email,sms',
            'data.to' => 'required',
        ];

        // Ajoutez des règles conditionnelles en fonction du type de notification
        if ($this->input('type') === 'email') {
            $rules['data.subject'] = 'required|string|max:255';
            $rules['data.body'] = 'required|string';
        } else {
            $rules['data.message'] = 'required|string|max:160';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Le type de notification est requis.',
            'type.in' => 'Le type de notification doit être "email" ou "sms".',
            'data.to.required' => 'Le destinataire est requis.',
            'data.subject.required' => 'Le sujet est requis pour un email.',
            'data.body.required' => 'Le corps du message est requis pour un email.',
            'data.message.required' => 'Le message est requis pour un SMS.',
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
