<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'name'          => 'required|unique:project|max:100',
            'description'   => 'required',
            'father_id'     => 'exists:project,id',
            'dependence_id' => 'exists:project,id',
            'cost'          =>  'min:0 | numeric ',
            'duration'      => 'min:0 | integer ', 
            'minCost'       =>  'min:0 |numeric', 
            'maxCost'       =>  'min:0 |numeric', 
            'minDuration'   => 'min:0 | integer', 
            'maxDuration'   => 'min:0 |integer',
            'initialDate'   => 'date',
            'finalDate'       => 'date|after:initialDate'

        ];
    }



    public function response(array $errors){
        
        $data = [
            'errors' => $errors
        ];

        return redirect()->back()->withInput()->withErrors($errors);
    }
}