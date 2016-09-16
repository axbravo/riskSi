<?php

namespace App\Http\Requests\Client;

use App\Http\Requests\Request;

class PasswordClientRequest extends Request
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
            'password' => 'required|min:6|max:16',
            'new_password' => 'required|confirmed|min:8|max:16'
        ];
    }

}
