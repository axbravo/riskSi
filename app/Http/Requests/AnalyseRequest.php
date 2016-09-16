<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnalyseRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            //'iteration'     => 'required|digits_between:100,1000'
        ];
    }

    public function response(array $errors){
        
        $data = [
            'errors' => $errors
        ];

        return redirect()->back()->withInput()->withErrors($errors);
    }
}