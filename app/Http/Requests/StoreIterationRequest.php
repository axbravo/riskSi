<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIterationRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'value'          => 'required|max:1000|min:100'
        ];
    }

    public function response(array $errors){
        
        $data = [
            'errors' => $errors
        ];

        return redirect()->back()->withInput()->withErrors($errors);
    }
}