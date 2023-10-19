<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DestinationRequest extends FormRequest
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
            'host' => ['required'],
            'port' => ['required'],
            'database' => ['required'],
            'user' => ['required'],
            'password' => ['required'],
            'table_name' => ['required'],
            'if_exists' => ['required'],
            'enable' => ['nullable']
        ];
    }
}
