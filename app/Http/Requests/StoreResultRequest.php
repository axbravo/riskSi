<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResultRequest extends FormRequest
{
    public function authorize() {
        return true;
    }


    public function response(array $errors){
        
        $data = [
            'errors' => $errors
        ];

        return redirect()->back()->withInput()->withErrors($errors);
    }
}