<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIterationRequest;
use App\Http\Requests\UpdateIterationRequest;
use App\Http\Requests\StoreVariableRequest;
use App\Http\Requests\UpdateVariableRequest;
use App\Http\Requests\StoreTypeDistributionRequest;
use App\Http\Requests\UpdateTypeDistributionRequest;
use App\Models\Distribution;
use App\Models\Iterations;
use App\Models\Variable;
use App\Models\Typedistribution;
use App\Services\FileService;


use Carbon\Carbon;

class DistributionController extends Controller
{ 

    public function __construct(){
        $this->file_service = new FileService();
    } 
    public function index()
    {
        $distributions = Typedistribution::where('deleted_at',NULL)->paginate(10);
        return view('internal.admin.distributions', ['distributions' => $distributions]);
    }

    
    public function create()
    {
        $distributions_list = Typedistribution::where('deleted_at', NULL)->lists('name','id');
        return view('internal.admin.newDistribution',['distributions_list' => $distributions_list]);
    }
    public function store(StoreTypeDistributionRequest $request)
    {
        $data = [
            'name'          =>$request->input('name'),
            ];
        $distribution = new Typedistribution();
        foreach ($data as $key => $value) {
            $distribution->$key = $value;
        }
        $distribution->save();
        return redirect()->route('admin.distribution.index');
    }

    public function edit($id)
    {
        $distribution =  Typedistribution::find($id);
        return view('internal.admin.editDistribution', ['distribution' => $distribution]);
    }

    public function update(UpdateTypedistributionRequest $request, $id)
    {
        $data = [
            'name'          =>$request->input('name',''),
        ];
        $distribution = Typedistribution::find($id);
        foreach ($data as $key => $value) {
            if($value!='')
                $distribution->$key = $value;
        }
        $distribution->save();
        return redirect()->route('admin.distribution.index');
    } 

    public function destroy($id)
    { 
        $distribution = Typedistribution::find($id); 
        $distribution->delete();
    
        return redirect()->route('admin.distribution.index');
    }

    public function indexIter()
    {
        $iterations = Iterations::where('deleted_at',NULL)->paginate(10);
        return view('internal.admin.iterations', ['iterations' => $iterations]);
    }

    
    public function createIter()
    {
        $iterations_list = Iterations::where('deleted_at', NULL)->lists('value','id');
        return view('internal.admin.newIterations',['iterations_list' => $iterations_list]);
    }
    public function storeIter(StoreIterationRequest $request)
    {
        $data = [
            'value'          =>$request->input('value'),
            ];
        $iteration = new Iterations();
        foreach ($data as $key => $value) {
            $iteration->$key = $value;
        }
        $iteration->save();
        return redirect()->route('admin.iteration.index');
    }

    public function editIter($id)
    {
        $iteration =  Iterations::find($id);
        return view('internal.admin.editIteration', ['iteration' => $iteration]);
    }

    public function updateIter(UpdateIterationRequest $request, $id)
    {
        $data = [
            'value'          =>$request->input('value',''),
        ];
        $iteration = Iterations::find($id);
        foreach ($data as $key => $value) {
            if($value!='')
                $iteration->$key = $value;
        }
        $iteration->save();
        return redirect()->route('admin.iteration.index');
    } 

    public function destroyIter($id)
    { 
        $iteration = Iterations::find($id); 
        $iteration->delete();
    
        return redirect()->route('admin.iteration.index');
    }

        public function indexVar()
    {
        $variables = Variable::where('deleted_at',NULL)->paginate(10);
        return view('internal.admin.variables', ['variables' => $variables]);
    }

    
    public function createVar()
    {
        $variables_list = Variable::where('deleted_at', NULL)->lists('name','id');
        return view('internal.admin.newVariable',['variables_list' => $variables_list]);
    }
    public function storeVar(StoreVariableRequest $request)
    {
        $data = [
            'name'          =>$request->input('name'),
            ];
        $variable = new Variable();
        foreach ($data as $key => $value) {
            $variable->$key = $value;
        }
        $variable->save();
        return redirect()->route('admin.variable.index');
    }

    public function editVar($id)
    {
        $variable =  Variable::find($id);
        return view('internal.admin.editVariable', ['variable' => $variable]);
    }

    public function updateVar(UpdateVariableRequest $request, $id)
    {
        $data = [
            'name'          =>$request->input('name',''),
        ];
        
        $variable = Iterations::find($id);
        foreach ($data as $key => $value) {
            $variable->$key = $value;
        }
        $variable->save();
        return redirect()->route('admin.variable.index');
    } 

    public function destroyVar($id)
    { 
        $variable = Variable::find($id); 
        $variable->delete();
    
        return redirect()->route('admin.variable.index');
    }
}

