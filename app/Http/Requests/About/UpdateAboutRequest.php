<?php

namespace App\Http\Requests\About;

use App\Http\Requests\Request;

class UpdateAboutRequest extends Request
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
            'description'   =>  'required|max:500',
            'mision'        =>  'required|max:500',
            'mision'        =>  'required|max:500',
            'history'       =>  'required|max:500',
            'youtube_url'   =>  'required|url',
            'image'         =>  'image'
        ];
    }
}
