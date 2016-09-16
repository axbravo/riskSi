<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIterationRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
             'value'          => 'required|max:1000'
        ];
    }

    public function response(array $errors){
        
        $data = [
            'errors' => $errors
        ];

        return redirect()->back()->withInput()->withErrors($errors);
    }
}