<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRisklevelRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'minProbability'       => 'required',
            'maxProbability'       => 'required',
            'minImpact'            => 'required',
            'maxImpact'            => 'required',
            'description'          => 'required'
        ];
    }

    public function response(array $errors){
        
        $data = [
            'errors' => $errors
        ];

        return redirect()->back()->withInput()->withErrors($errors);
    }
}