<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChecklistRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'question'          => 'required|max:250',
            'risk'              => 'required|max:250'
        ];
    }

    public function response(array $errors){
        
        $data = [
            'errors' => $errors
        ];

        return redirect()->back()->withInput()->withErrors($errors);
    }
}