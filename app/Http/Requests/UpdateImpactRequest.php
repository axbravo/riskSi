<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateImpactRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'cost'          => 'required',
            'schedule'      => 'required',
            'value'         => 'required|max:5'
        ];
    }

    public function response(array $errors){
        
        $data = [
            'errors' => $errors
        ];

        return redirect()->back()->withInput()->withErrors($errors);
    }
}