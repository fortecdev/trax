<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateSong extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|unique:songs,title',
            'artist' => 'required',
            'year' => 'required|integer',
            'producer' => 'required',
            'genre_id' => 'required|integer' ,
            'image' => 'mimes:jpg,jpeg,png'
        ];
    }
}
