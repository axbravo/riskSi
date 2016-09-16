<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRiskRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'name'          => 'max:100|unique:risk,name,'.$this->input('id'),
            'description'   => '',
            'father_id'     => 'exists:risk,id'
        ];
    }

    public function response(array $errors){
        
        $data = [
            'errors' => $errors
        ];

        return redirect()->back()->withInput()->withErrors($errors);
    }
}