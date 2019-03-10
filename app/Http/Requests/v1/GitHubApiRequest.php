<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;

class GitHubApiRequest extends FormRequest
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
            'fromDb' => 'required|boolean',
            'page' => 'string|min:1',
            'perPage' => 'integer|between:1,10',
        ];
    }
}
