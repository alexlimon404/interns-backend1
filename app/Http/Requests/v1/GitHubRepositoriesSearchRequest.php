<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class GitHubRepositoriesSearchRequest extends FormRequest
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
     * Get num 4
     * @return array
     */
    public function rules()
    {
        return [
            'fromDb' => 'required|boolean',
            'page' => 'string|min:1',
            'perPage' => 'integer|between:1,10',
            'title' => 'string|max:200',
            'private' => 'boolean',
            'language' => 'string|max:3',
        ];
    }
}
