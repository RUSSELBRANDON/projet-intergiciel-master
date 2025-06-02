<?php

namespace App\Http\Requests\BookRequests;

use App\Enums\BookStatusEnum;
use App\Enums\GenreEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Enum;

class CreateBookRequest extends FormRequest
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
            'title'=> 'required|string|max:255|unique:books,title',
            'author'=> 'required|string|max:255',
            'publication_date'=>'required|date_format:d/m/Y',
            'genre' => ['required', new Enum(GenreEnum::class)],
            'status' => ['required', new Enum(BookStatusEnum::class)],
        ];
    }

    public function messages()
    {
        return [
            'title.required'=>'the title field is required',
            'author.required'=> 'the author field is required',
            'publication_date.required'=>'the publication date field is required',
            'publication_date.date_format'=>'the correct date format is d/m/y',
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
