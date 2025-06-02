<?php

namespace App\Http\Requests\UserRequests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateUserRequest extends FormRequest
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
            "username"=>"required|string|max:255",
            "email"=>"required|email|unique:users,email|max:255",
            "password"=>"required|string|min:4",

            
        ];
    }

    public function message(){
        return [
            'username.required' => 'userName field is required',
            'email.required' => 'Email address is required',
            'email.email' => 'Please enter a valid email address',
            'password.required'=>'password field is required',
            'password.min'=>'min length for password is 4'
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
