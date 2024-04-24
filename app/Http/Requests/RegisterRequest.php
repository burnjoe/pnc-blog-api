<?php

namespace App\Http\Requests;

use App\Rules\StrongPassword;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        // TODO: Do not require image upon creation
        return [
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|min:5|max:255|unique:users',
            // 'image' => 'file|image|mimes:jpeg,png,jpg|max:2048', // 2MB
            'password' => ['required', 'string', 'min:8', 'confirmed', new StrongPassword],
            'account_type' => 'required|string|in:Writer',
            'provider' => 'required|string|min:2|max:255'
        ];
    }
}
