<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrailerRequest extends FormRequest
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
        return [
            'trailer' => ['sometimes', 'required', 'file', 'mimetypes:video/mp4'],
            'poster' => ['sometimes', 'file', 'mimetypes:image/*'],
        ];
    }

    public function messages() {
        return [
            'file' => 'Ошибка в файле',
            'poster.mimetypes' => 'Загрузите изображение',
            'trailer.mimetypes' => 'Загрузите видео MP4',
        ];
    }
}
