<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Movie;
use Illuminate\Validation\Rule;

class CreateMovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // こっちは入力されたデータに対するユニークのバリデーション
            // テーブルそのものをユニークにしたいなら、migrationファイルを変更する
            'title' => ['required', Rule::unique('movies')->ignore($this ->id)],
            'image_url' => ['required', 'url'], // ok
            'published_year' => ['required'], // ok
            'description' => ['required'], // ok
            'is_showing' => ['required', 'boolean'], // out
            // 'name' => ['required', 'unique:genres,name'], // out
            'genre' => ['required'],
        ];
    }
}
