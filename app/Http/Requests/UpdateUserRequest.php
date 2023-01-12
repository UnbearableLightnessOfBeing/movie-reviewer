<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        // dd($this->id);
        return [
            // 'name' => ['required', Rule::unique('users')->ignore($this->user()->id, 'id')],
            // 'isAdmin' => ['required']
        ];
    }

    public function messages() {
        return [
            'required' => 'Поле необходимо заполнить',
            'unique' => 'Пользователь с таким именем уже добавлен',
        ];
    }
}
