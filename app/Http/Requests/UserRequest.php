<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user') ? $this->route('user') : null;
        
        return [
            'name' => 'required|string|min:5|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
            'password' => $this->isMethod('post') ? 'required|min:6' : 'nullable|min:6',
        ];
    }
}