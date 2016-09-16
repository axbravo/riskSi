<?php

namespace App\Http\Requests\Attendance;

use App\Http\Requests\Request;

class AttendanceRequest extends Request
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
            'dateIni'       =>  'max:20|date',
            'dateEnd'      =>  'max:20|date'  
               
        ];
    }
}
