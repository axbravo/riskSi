<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreAdminRequest;
use App\Http\Requests\User\UpdateAdminRequest;
use App\user;
use Carbon\Carbon;
use App\Services\FileService;
use App\Models\ModuleAssigment;
use App\Http\Requests\Client\PasswordClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use Auth;
use Session;

class AdminController extends Controller
{
    public function __construct(){
        $this->file_service = new FileService();
    }

    public function client()
    {
        return view('internal.admin.client');
    }
    public function analist()
    {

        $analists = User::where('role_id',5)->paginate(10);
        $analists->setPath('analist');

        return view('internal.admin.analist',compact('analists'));
    }

    public function riskmanager()
    {

        $riskmanagers = User::where('role_id',2)->paginate(10);
        $riskmanagers->setPath('riskmanager');

        return view('internal.admin.riskmanager',compact('riskmanagers'));
    }

    public function projectManager()
    {

        $projectManagers = User::where('role_id',1)->paginate(10);
        $projectManagers->setPath('projectManager');

        return view('internal.admin.projectManager',compact('projectManagers'));
    }

    public function portmanager()
    {

        $portmanagers = User::where('role_id',3)->paginate(10);
        $portmanagers->setPath('portmanager');

        return view('internal.admin.portmanager',compact('portmanagers'));
    }

    public function editAnalist($id)
    {
        $user = User::find($id);
        return view('internal.admin.editAnalist',compact('user'));
    }


    public function updateAnalist(UpdateAdminRequest $request, $id)
    {

        $input = $request->all();

        $user = User::find($id);
        $user->name         =   $input['name'];
        $user->lastName     =   $input['lastname'];
        /*
        if ($input['password'] != null )
            $user->password     =   bcrypt($input['password']);*/

        $user->di_type      =   $input['di_type'];
        $user->di           =   $input['di'];
        $user->address      =   $input['address'];
        $user->phone        =   $input['phone'];
        $user->email        =   $input['email'];
        $user->birthday     =   new Carbon($input['birthday']);
        $user->role_id      =   $input['role_id'];

        $birthday =  new \DateTime ($input['birthday']);
        $currentDate = new \DateTime('now');
        $interval = $birthday->diff($currentDate);
        if($interval->format('%y') < 18){ 
            //return back()->withInput($request->except('seats'))->withErrors(['El asiento '. $seat_id.' no esta libre']);
            return back()->withErrors(['El usuario debe tener más de 18 años']);
        }
        /*
        if($request->file('image')!=null)
           $user->image        =   $this->file_service->upload($request->file('image'),'user');
        */
        $user->save(); 

        return redirect('admin/analist');
    }


    public function editRiskManager($id)
    {

        $user = User::find($id);
        return view('internal.admin.editRiskManager',compact('user'));
    }

    public function updateRiskManager(UpdateAdminRequest $request, $id)
    {

        $input = $request->all();

        $user = User::find($id);
        $user->name         =   $input['name'];
        $user->lastName     =   $input['lastname'];
        /*
        if ($input['password'] != null )
            $user->password     =   bcrypt($input['password']);*/

        $user->di_type      =   $input['di_type'];
        $user->di           =   $input['di'];
        $user->address      =   $input['address'];
        $user->phone        =   $input['phone'];
        $user->email        =   $input['email'];
        $user->birthday     =   new Carbon($input['birthday']);
        $user->role_id      =   $input['role_id'];

        $birthday =  new \DateTime ($input['birthday']);
        $currentDate = new \DateTime('now');
        $interval = $birthday->diff($currentDate);
        if($interval->format('%y') < 18){ 
            //return back()->withInput($request->except('seats'))->withErrors(['El asiento '. $seat_id.' no esta libre']);
            return back()->withErrors(['El usuario debe tener más de 18 años']);
        }
        $user->save();

        return redirect('admin/riskmanager');
    }

    public function editprojectManager($id)
    {

        $user = User::find($id);
        return view('internal.admin.editprojectManager',compact('user'));
    }

    public function updateprojectManager(UpdateAdminRequest $request, $id)
    {

        $input = $request->all();

        $user = User::find($id);
        $user->name         =   $input['name'];
        $user->lastName     =   $input['lastname'];
        /*
        if ($input['password'] != null )
            $user->password     =   bcrypt($input['password']);*/

        $user->di_type      =   $input['di_type'];
        $user->di           =   $input['di'];
        $user->address      =   $input['address'];
        $user->phone        =   $input['phone'];
        $user->email        =   $input['email'];
        $user->birthday     =   new Carbon($input['birthday']);
        $user->role_id      =   $input['role_id'];

        $birthday =  new \DateTime ($input['birthday']);
        $currentDate = new \DateTime('now');
        $interval = $birthday->diff($currentDate);
        if($interval->format('%y') < 18){ 
            //return back()->withInput($request->except('seats'))->withErrors(['El asiento '. $seat_id.' no esta libre']);
            return back()->withErrors(['El usuario debe tener más de 18 años']);
        }
        $user->save();

        return redirect('admin/projectManager');
    }

     public function editPortManager($id)
    {

        $user = User::find($id);
        return view('internal.admin.editPortManager',compact('user'));
    }

    public function updatePortManager(UpdateAdminRequest $request, $id)
    {

        $input = $request->all();

        $user = User::find($id);
        $user->name         =   $input['name'];
        $user->lastName     =   $input['lastname'];
        /*
        if ($input['password'] != null )
            $user->password     =   bcrypt($input['password']);*/

        $user->di_type      =   $input['di_type'];
        $user->di           =   $input['di'];
        $user->address      =   $input['address'];
        $user->phone        =   $input['phone'];
        $user->email        =   $input['email'];
        $user->birthday     =   new Carbon($input['birthday']);
        $user->role_id      =   $input['role_id'];

        $birthday =  new \DateTime ($input['birthday']);
        $currentDate = new \DateTime('now');
        $interval = $birthday->diff($currentDate);
        if($interval->format('%y') < 18){ 
            //return back()->withInput($request->except('seats'))->withErrors(['El asiento '. $seat_id.' no esta libre']);
            return back()->withErrors(['El usuario debe tener más de 18 años']);
        }
        $user->save();

        return redirect('admin/riskportmanager');
    }
    public function admin()
    {
        $users = User::where('role_id',4)->paginate(10);
        $users->setPath('admin');
        return view('internal.admin.admin', compact('users'));
    }

    public function editAdmin($id)
    {
        $user = User::find($id);

        return view('internal.admin.editAdmin', compact('user'));
    }

    public function updateAdmin(UpdateAdminRequest $request, $id)
    {
        $input = $request->all();

        $user = User::find($id);
        $user->name         =   $input['name'];
        $user->lastName     =   $input['lastname'];
        /*

        if ($input['password'] != null )
            $user->password     =   bcrypt($input['password']);*/

        $user->di_type      =   $input['di_type'];
        $user->di           =   $input['di'];
        $user->address      =   $input['address'];
        $user->phone        =   $input['phone'];
        $user->email        =   $input['email'];
        $user->birthday     =   new Carbon($input['birthday']);
        $user->role_id      =   $input['role_id'];

        $birthday =  new \DateTime ($input['birthday']);
        $currentDate = new \DateTime('now');
        $interval = $birthday->diff($currentDate);
        if($interval->format('%y') < 18){ 
            //return back()->withInput($request->except('seats'))->withErrors(['El asiento '. $seat_id.' no esta libre']);
            return back()->withErrors(['El usuario debe tener más de 18 años']);
        }
        /*
        if($request->file('image')!=null)
           $user->image        =   $this->file_service->upload($request->file('image'),'user');
        */
        $user->save();

        return redirect('admin/admin');
    }

    public function newUser()
    {
        return view('internal.admin.newUser');

    }


    public function store(StoreAdminRequest $request)
    {
        $input = $request->all();

        $user               =   new User ;
        $user->name         =   $input['name'];
        $user->lastName     =   $input['lastname'];
        $user->password     =   bcrypt($input['password']);
        $user->di_type      =   $input['di_type'];
        $user->di           =   $input['di'];
        $user->address      =   $input['address'];
        $user->phone        =   $input['phone'];
        $user->email        =   $input['email'];

        $user->birthday     =   new Carbon($input['birthday']);


        $user->role_id      =   $input['role_id'];
        if($request->file('image')!=null)
           $user->image        =   $this->file_service->upload($request->file('image'),'user');

        // validate la edad del usuario 

        $birthday =  new \DateTime ($input['birthday']);
        $currentDate = new \DateTime('now');
        $interval = $birthday->diff($currentDate);
        if($interval->format('%y') < 18){ 
            //return back()->withInput($request->except('seats'))->withErrors(['El asiento '. $seat_id.' no esta libre']);
            return back()->withErrors(['El usuario debe tener más de 18 años']);
        }

        $user->save();

        if($user->role_id == '4')
             return redirect('admin/admin');
        elseif ($user->role_id == '3')
            return redirect('admin/portmanager');
        elseif ($user->role_id == '2')
            return redirect('admin/riskmanager');
        elseif ($user->role_id == '1')
            return redirect('admin/riskresponsable');
        elseif ($user->role_id == '5')
            return redirect('admin/analist');

    }

        public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('admin/admin');

   }

    public function destroyRiskManager($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('admin/riskmanager');
    }

    public function destroyPortManager($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('admin/portmanager');
    }

    public function destroyprojectManager($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('admin/projectManager');
    }
    public function destroyAnalist($id)
    {
        $moduleassigment = ModuleAssigment::where('analist_id',$id)->where('status',1)->get();

            $user = User::find($id);
            $user->delete();

        return redirect('admin/analist');
    }


    public function passwordAdmin()
    {
        return view('internal.admin.password');
    }


    public function passwordUpdateAdmin(PasswordClientRequest $request)
    {

        $id = Auth::user()->id;
        $obj = User::findOrFail($id);
        $auth = Auth::attempt( array(
            'email' => $obj->email,
            'password' => $request->input('password')
            ));
        if ($auth)
        {
            $newPassword = bcrypt($request->input('new_password'));
            $obj->password = $newPassword;
            $obj->save();
            //ERROR DE MENSAJES EN INGLES, DEBEN SER EN ESPAÑOL CUANDO SON CUSTOM
            Session::flash('message', 'Su contraseña fue actualizada!');
            Session::flash('alert-class','alert-success');
        } else {
            Session::flash('message', 'Contraseña Incorrecta!');
            Session::flash('alert-class','alert-danger');
        }
        return redirect('admin');
    }

}
    