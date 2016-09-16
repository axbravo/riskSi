<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRbsRequest;
use App\Http\Requests\UpdateRbsRequest;
use App\Models\Rbs;
use App\Models\Risk;
use App\Services\FileService;


use Carbon\Carbon;

class RbsController extends Controller
{ 

    public function __construct(){
        $this->file_service = new FileService();
    } 
    public function index()
    {
        $rbss = Rbs::where('type',1)->paginate(10);
        $subcat_list = [];
        foreach ($rbss as $rbs) {
            $subcat_list[$rbs->name] = $this->getsubrbss($rbs->id);
        }
        return view('internal.admin.rbs', ['rbss' => $rbss, 'subrbss' => $subcat_list]);
    }

    public function indexSub($id)
    {
        $rbs = Rbs::findOrFail($id);

        $subrbss_pure = Risk::where('father_id',$id)->get();
        
        $subrbss = Rbs::where('father_id',$id)->paginate(10);
        $subrbss->setPath('subrbss');
        return view('internal.admin.subrbs',['rbs'=>$rbs,"subrbss"=>$subrbss,"subrbss_pure"=>$subrbss_pure]);
    }

    public function indexSubAdmin($parent_rbs)
    {
        $rbss = Rbs::where('father_id',$parent_rbs)->paginate(5);
        $rbss->setPath('subrbss');
        return view('internal.admin.subrbs', ['rbss' => $rbss]);
    }

    
    public function create()
    {
        $rbs_list = Rbs::where('type', '1')->lists('name','id');
        return view('internal.admin.newrbs',['rbs_list' => $rbs_list]);
    }
    public function store(StoreRbsRequest $request)
    {
        $data = [
            'name'          =>$request->input('name'),
            'description'   =>$request->input('description')
            ];
        $rbs = new Rbs();
        foreach ($data as $key => $value) {
            $rbs->$key = $value;
        }
        $father_id = $request->input('father_id', '');
        if($request['isSub'] == null){
            $rbs->type = 1;
            $rbs->father_id = null;
        } else {
            $rbs->type = 2;
            $parent = Rbs::find($father_id);
            $rbs->parentrbs()->associate($parent);
        }
        $rbs->save();
        return redirect()->route('admin.rbs.index');
    }

    public function edit($id)
    {
        $rbs =  Rbs::find($id);
        $rbs_list = Rbs::where('type', '1')->lists('name','id');
        return view('internal.admin.editrbs', ['rbs' => $rbs, 'rbs_list' => $rbs_list]);
    }
/*
    public function showSub($id, $id2)
    {
        $project = Project::findOrFail($id2);
        $risks = Risk::where('project_id',$id2);

        return view('internal.project',["risks"=>$risks,"project"=>$project]);
    }
*/

    public function update(UpdateRbsRequest $request, $id)
    {
        $data = [
            'name'          =>$request->input('name',''),
            'description'   =>$request->input('description','')
        ];
        $rbs = Rbs::find($id);
        foreach ($data as $key => $value) {
            if($value!='')
                $rbs->$key = $value;
        }

        $father_id = $request->input('father_id', '');
        if($rbs->father_id){
            $rbs->type = 2;
            $rbs->father_id = $father_id;
        }
        $rbs->save();
        return redirect()->route('admin.rbs.index');
    } 

    public function destroy($id)
    { 
        $rbs = Rbs::find($id); 
        $subrbss = $this->getsubrbss($id)->toArray();
        if(!empty($subrbss)){ 
            $errors = ['El rbs tiene niveles'];
            return redirect()->back()->withErrors($errors);
        }
        if (!is_null($rbs)) {
            $rbs->delete();
        }
        $rbs->delete();
    
        return redirect()->route('admin.rbs.index');
    }


    public function getsubrbss($rbs_id){
        return rbs::where('father_id', $rbs_id)->get();
    } 
}

