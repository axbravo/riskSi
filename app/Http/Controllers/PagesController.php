<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Models\About;
use Carbon\Carbon;
use App\Models\Presentation;
use DB;

class PagesController extends Controller
{
    public function home()
    {
        return view('external.home');
    }

    public function adminHome()
    {
        return view('internal.admin.home');
    }

    public function analistHome()
    {
        return view('internal.analist.home');
    }

    public function riskmanagerHome()
    {
        return view('internal.riskmanager.home');
    }

    public function portmanagerHome()
    {
        return view('internal.portmanager.home');
    }

    public function projectmanagerHome()
    {
        return view('internal.projectmanager.home');
    }
}
