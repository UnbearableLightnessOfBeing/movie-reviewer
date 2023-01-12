<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
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
            'title' => ['required', 'unique:movies,title', 'max:100'],
            'duration' => ['required', 'integer', 'max:999'],
            'release_date' => ['required', 'date'],
            'production' => ['required', 'max:100'],
            'restriction' => ['required'],
            'description' => ['sometimes', 'max:5000']
        ];
    }


    public function messages() {
        return [
            'required' => 'Поле необходимо заполнить',
            'unique' => 'Такой жанр уже добавлен',
            'integer' => 'Введите число',
            'date' => 'Введите дату',
            'duration.max' => 'Число должно быть меньше четырехзначного',
            'title.max' => 'Слишком длинное название',
            'production.max' => 'Слишком длинное название'
        ];
    }
}
