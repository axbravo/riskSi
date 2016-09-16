<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExchangeRate\StoreExchangeRateRequest;
use App\Http\Requests\ExchangeRate\UpdateExchangeRateRequest;
use App\Models\ExchangeRate;
use App\Http\Requests\Attendance\AttendanceRequest;
use App\Http\Requests\Attendance\AttendanceSubmitRequest;
use App\Http\Requests\Attendance\AttendanceUpdate;
use App\Http\Requests\About\UpdateAboutRequest;
use App\Http\Requests\System\UpdateSystemRequest;
use App\Services\FileService;

use Auth;
use App\User;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\AttendanceDetail;

use App\Models\Business;
use App\Models\About;

use App\Models\CashcountHistorial;
use DB;

use App\Http\Requests\Client\PasswordClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use Session;




/*use App\Services\FileService;*/

class BusinessController extends Controller
{
    public function __construct(){
        $this->file_service = new FileService();
    }

    public function system()
    {
        $system = Business::all()->first();
        

        return view('internal.admin.system', compact('system'));
    }

    public function systemUpdate(UpdateSystemRequest $request)
    {
        $system = Business::all()->first();
        $system->business_name  =   $request['business_name'];
        $system->ruc            =   $request['ruc'];
        $system->address        =   $request['address'];
        $system->reserve_time   =   $request['reserve_time'];

        if($request['gift_module_id'] == 0){
            $system->gift_module_id =   null;    
        }else{
            $system->gift_module_id =   $request['gift_module_id'];
        }
        
        if(isset($request['logo']))
            $system->logo = $this->file_service->upload($request->file('logo'),'system');

        if(isset($request['favicon']))
            $system->favicon = $this->file_service->upload($request->file('favicon'),'system');

        $system->save();

        Session::flash('message', 'Se actualizaron los datos!');
        Session::flash('alert-class','alert-success');
        return redirect()->back();
    }


}
