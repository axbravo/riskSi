<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class UpdateAdminRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        //
              'name'     => 'required|max:100',
              'lastname' => 'required|max:100',
              'password' => '',
              'di_type'  => 'required',
              'di'       => 'required|integer|digits:8:users,di,NULL,id,role_id,1|:users,di,NULL,id,role_id,5|:users,di,NULL,id,role_id,2|:users,di,NULL,id,role_id,3|:users,di,NULL,id,role_id,4',
              'address'  => 'required|max:100', 
              'phone'    => 'required|integer|digits_between:7,9',
              'email'    => 'required|unique:users,email,'.$this->input('id'), 
              'birthday' => 'date|required',
              'role_id'  => 'required',
            
        ];
    } 
}
