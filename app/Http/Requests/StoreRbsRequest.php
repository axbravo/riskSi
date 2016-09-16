<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRbsRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'name'          => 'required|unique:rbs|max:100',
            'description'   => 'required',
            'father_id'     => 'exists:rbs,id'
        ];
    }

    public function response(array $errors){
        
        $data = [
            'errors' => $errors
        ];

        return redirect()->back()->withInput()->withErrors($errors);
    }
}