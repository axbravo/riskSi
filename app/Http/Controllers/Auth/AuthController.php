<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;
use Carbon\Carbon;
use Config;

class AuthController extends Controller
{
  
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    public function getLogout()
    {   
        Auth::logout();
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }
    protected $redirectAfterLogout = '/';

    protected $loginPath = '/auth/login';
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:32',
            'email' => 'required|email|max:64|unique:users',
            'password' => 'required|confirmed|min:6',
            ]);
    }
    protected function create(array $data)
    {
        $role = 1;
        if (isset($data['role_id']))
            $role = $data['role_id'];
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role_id' => $role
            ]);
    }
    public function redirectPath()
    {
        switch (\Auth::user()->role_id) {
            case '4':
            return '/admin';
            break;
            case '5':
            return '/analist';
            break;
            case '3':
            return '/portmanager';
            break;
            case '2':
            return '/riskmanager';
            break;
            case '1':
            return '/projectManager';
            break;
    default:
    return '/';
    break;
}
}
}
