<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRiskRequest; 
use App\Http\Requests\UpdateRiskRequest; 
use App\Http\Requests\StoreImpactRequest; 
use App\Http\Requests\UpdateImpactRequest; 
use App\Http\Requests\StoreProbabilityRequest; 
use App\Http\Requests\UpdateProbabilityRequest; 
use App\Http\Requests\StoreRisklevelRequest; 
use App\Http\Requests\UpdateRisklevelRequest; 
use App\Http\Requests\StoreChecklistRequest; 
use App\Http\Requests\UpdateChecklistRequest; 
use App\Models\Risk;
use App\Models\Rbs;
use App\Models\Impact;
use App\Models\Checklist;
use App\Models\Probability;
use App\Models\Risklevel;
use App\Services\FileService;
use App\User;
use Auth;
use Carbon\Carbon;

class RiskController extends Controller
{ 

    public function __construct(){
        $this->file_service = new FileService();
    } 
    public function index()
    {
        $risks = Risk::where('type',1)->paginate(10);
        $subcat_list = [];
        foreach ($risks as $risk) {
            $subcat_list[$risk->name] = $this->getsubrisks($risk->id);
        }
         
        return view('internal.projectmanager.catalogs', ['risks' => $risks, 'subrisks' => $subcat_list]);
    }
     public function issuelog()
    {
        $risks = Risk::where("type" ,'1')->paginate(10);
        $subcat_list = [];
        foreach ($risks as $risk) {
            $subcat_list[$risk->name] = $this->getsubrisks($risk->id);
        }
         
        return view('internal.projectmanager.issuelogs', ['risks' => $risks, 'subrisks' => $subcat_list]);
    }
    public function indexRiskM()
    {   $id = Auth::user()->id;
        $risks = Risk::where('type',1)->paginate(10);
        $subcat_list = [];
        foreach ($risks as $risk) {
            $subcat_list[$risk->name] = $this->getsubrisks($risk->id);
        }
         
        return view('internal.riskmanager.catalogs', ['risks' => $risks, 'subrisks' => $subcat_list]);
    }

    public function indexPortM()
    {   $id = Auth::user()->id;
        $risks = Risk::where('type',1)->paginate(10);
        $subcat_list = [];
        foreach ($risks as $risk) {
            $subcat_list[$risk->name] = $this->getsubrisks($risk->id);
        }
         
        return view('internal.portmanager.catalogs', ['risks' => $risks, 'subrisks' => $subcat_list]);
    }

    public function indexImpact()
    {   $id = Auth::user()->id;
        $impacts = Impact::where('riskmanager_id',$id)->paginate(10);
        return view('internal.riskmanager.impacts', ['impacts' => $impacts]);
    }

    public function indexProbability()
    {   $id = Auth::user()->id;
        $probabilities = Probability::where('riskmanager_id',$id)->paginate(10);
        return view('internal.riskmanager.probability', ['probabilities' => $probabilities]);
    }

    public function indexRisklevel()
    {   $id = Auth::user()->id;
        $risklevels = Risklevel::where('riskmanager_id',$id)->paginate(10);
        return view('internal.riskmanager.risklevel', ['risklevels' => $risklevels]);
    }

    public function indexRiskR()
    {
        $id = Auth::user()->id;
        $risks = Risk::where(["riskresponsable_id"=>$id,"type" =>'1'])->paginate(10);
        $subcat_list = [];
        $responrisk_list = [];
        foreach ($risks as $risk) {
            $subcat_list[$risk->name] = $this->getsubrisks($risk->id);
        }
        foreach ($risks as $risk) {
            if($risk->riskresponsable_id==$id)
            $responrisk_list[$risk->name] = $risk;
        }
         
        return view('internal.riskresponsable.risks', ['risks' => $risks, 'subrisks' => $subcat_list,'responrisk_list' => $responrisk_list]);
    }


    public function indexSub($id)
    {
        $risk = Risk::findOrFail($id);
        $subrisks_pure = Risk::where('father_id',$id)->get();
        
        $subrisks = Risk::where('father_id',$id)->paginate(10);
        $subrisks->setPath('subrisks');
        return view('internal.projectmanager.risks',['risk'=>$risk,"subrisks"=>$subrisks,'subrisks_pure'=>$subrisks_pure]);
    }

     public function indexSubissue($id)
    {
        $risk = Risk::findOrFail($id);
        $subrisks_pure = Risk::where(["father_id"=>$id,"state" =>'Terminado'])->get();
        
        $subrisks = Risk::where(["father_id"=>$id,"state" =>'Terminado'])->paginate(10);
        $subrisks->setPath('subrisks');
        return view('internal.projectmanager.issues',['risk'=>$risk,"subrisks"=>$subrisks,'subrisks_pure'=>$subrisks_pure]);
    }

    public function indexSubRiskM($id)
    {
        $risk = Risk::findOrFail($id);
        $subrisks_pure = Risk::where('father_id',$id)->get();
        $subrisks = Risk::where('father_id',$id)->paginate(10);
        $subrisks->setPath('subrisks');
        return view('internal.riskmanager.risks',['risk'=>$risk,"subrisks"=>$subrisks,'subrisks_pure'=>$subrisks_pure]);
    }

    public function indexSubPortM($id)
    {
        $risk = Risk::findOrFail($id);
        $subrisks_pure = Risk::where('father_id',$id)->get();
        $subrisks = Risk::where('father_id',$id)->paginate(10);
        $subrisks->setPath('subrisks');
        return view('internal.portmanager.risks',['risk'=>$risk,"subrisks"=>$subrisks,'subrisks_pure'=>$subrisks_pure]);
    }

    public function indexSubAnalist()
    {
        $id = Auth::user()->id;
        $subrisks = Risk:: where(["riskresponsable_id"=>$id,"type" =>'2'])->paginate(10);
        $subrisks->setPath('subrisks');
        return view('internal.analist.risks',["subrisks"=>$subrisks]);
    }

    public function indexSubAdmin($parent_risk)
    {
        $risks = Risk::where('father_id',$parent_risk)->paginate(5);
        $risks->setPath('subrisks');
        return view('internal.admin.risks', ['risks' => $risks]);
    }

    public function create()
    {
        $risk_list = Risk::where('type', '1')->lists('name','id');
        $rbss_list = Rbs::where('type',2)->lists('name','id');
        $riskresponsable_list=User::where('deleted_at',NULL)->lists('name','id');
        $array = ['risk_list' =>$risk_list,
                  'rbss_list'   =>$rbss_list,
                  'riskresponsable_list'=>$riskresponsable_list];
        return view('internal.projectmanager.newCatalog',$array);
    }

    public function createresponse($id)
    {
        $risk= Risk::find($id);
        $riskresponsable_list=User::where('deleted_at',NULL)->lists('name','id');
        $array = ['risk' =>$risk,
                  'riskresponsable_list'=>$riskresponsable_list];
        return view('internal.projectmanager.newResponseplan',$array);
    }

    public function createRiskM()
    {
        $risk_list = Risk::where('type', '1')->lists('name','id');
        $rbss_list = Rbs::where('type',2)->lists('name','id');
        $riskresponsable_list=User::where('deleted_at',NULL)->lists('name','id');
        $array = ['risk_list' =>$risk_list,
                  'rbss_list'   =>$rbss_list,
                  'riskresponsable_list'=>$riskresponsable_list];
        return view('internal.riskmanager.newCatalog',$array);
    }

    public function createPortM()
    {
        $risk_list = Risk::where('type', '1')->lists('name','id');
        $rbss_list = Rbs::where('type',2)->lists('name','id');
        $riskresponsable_list=User::where('deleted_at',NULL)->lists('name','id');
        $array = ['risk_list' =>$risk_list,
                  'rbss_list'   =>$rbss_list,
                  'riskresponsable_list'=>$riskresponsable_list];
        return view('internal.portmanager.newCatalog',$array);
    }


    public function createImpact()
    {

        return view('internal.riskmanager.newImpact');
    }

    public function createProbability()
    {

        return view('internal.riskmanager.newProbability');
    }

    public function createRisklevel()
    {
        $id               = Auth::user()->id;
        $probability_list = Probability::where('riskmanager_id',$id)->lists('value','id');
        $impact_list      = Impact::where('riskmanager_id',$id)->lists('value','id');
        $array = ['probability_list' =>$probability_list,
                  'impact_list'      =>$impact_list];
        return view('internal.riskmanager.newRisklevel', $array);
    }

    public function storeImpact(StoreImpactRequest $request)
    {
        $id = Auth::user()->id;

        $data = [
            'riskmanager_id'      =>$id,
            'schedule'     =>$request->input('schedule'),
            'cost'          =>$request->input('cost'),
            'value'          =>$request->input('value')
            ];
        $impact = new Impact();
        foreach ($data as $key => $value) {
            $impact->$key = $value;
        }

        $impact->save();
        return redirect()->route('riskmanager.impact.indexImpact');
    }

    public function storeProbability(StoreProbabilityRequest $request)
    {
        $id = Auth::user()->id;

        $data = [
            'riskmanager_id'      =>$id,
            'description'         =>$request->input('description'),
            'value'               =>$request->input('value')
            ];
        $probability = new Probability();
        foreach ($data as $key => $value) {
            $probability->$key = $value;
        }

        $probability->save();
        return redirect()->route('riskmanager.probability.indexProbability');
    }

    public function storeRisklevel(StoreRisklevelRequest $request)
    {
        $id = Auth::user()->id;

        $data = [
            'riskmanager_id'      =>$id,
            'minProbability'      =>$request->input('minProbability'),
            'maxProbability'      =>$request->input('maxProbability'),
            'minImpact'           =>$request->input('minImpact'),
            'maxImpact'           =>$request->input('maxImpact'),
            'description'         =>$request->input('description')
            ];
        $risklevel = new Risklevel();
        foreach ($data as $key => $value) {
            $risklevel->$key = $value;
        }

        $risklevel->save();
        return redirect()->route('riskmanager.risklevel.indexRisklevel');
    }

    public function storeresponse(StoreRiskRequest $request)
    {
        $data = [
            'name'          =>$request->input('name'),
            'description'   =>$request->input('description'),
            'state'         =>'Creado',
            'factor'        =>$request->input('factor'),
            'type_risk'     =>'Creado',
            'impact'        =>$request->input('impact'),
            'probability'   =>$request->input('probability'),
            'importance'    =>$request->input('importance'),
            'cost'          =>$request->input('cost'),
            'duration'      =>$request->input('duration')
            ];
        $risk = new Risk();
        foreach ($data as $key => $value) {
            $risk->$key = $value;
        }
        $father_id = $request->input('father_id', '');
        if($request['isSub'] == null){
            $risk->type = 1;
            $risk->father_id = null;
        } else {
            $risk->type = 2;
            $parent = Risk::find($father_id);
            $risk->parentRisk()->associate($parent);
        }
        $risk->save();
        return redirect()->route('projectManager.task.index');
    }

    public function store(StoreRiskRequest $request)
    {
        $data = [
            'name'          =>$request->input('name'),
            'description'   =>$request->input('description'),
            'state'         =>'Creado',
            'factor'        =>$request->input('factor'),
            'type_risk'     =>'Creado',
            'impact'        =>$request->input('impact'),
            'probability'   =>$request->input('probability'),
            'importance'    =>$request->input('importance'),
            'cost'          =>$request->input('cost'),
            'duration'      =>$request->input('duration')
            ];
        $risk = new Risk();
        foreach ($data as $key => $value) {
            $risk->$key = $value;
        }
        $father_id = $request->input('father_id', '');
        if($request['isSub'] == null){
            $risk->type = 1;
            $risk->father_id = null;
        } else {
            $risk->type = 2;
            $parent = Risk::find($father_id);
            $risk->parentRisk()->associate($parent);
        }
        $risk->save();
        return redirect()->route('projectManager.task.index');
    }
    public function storeRiskM(StoreRiskRequest $request)
    {
        $data = [
            'name'           =>$request->input('name'),
            'description'    =>$request->input('description'),
            'state'          =>'Creado',
            'factor'         =>$request->input('factor'),
            'type_risk'      =>'Creado',
            'impact'         =>$request->input('impact'),
            'probability'    =>$request->input('probability'),
            'importance'     =>$request->input('importance'),
            'cost'           =>$request->input('cost'),
            'duration'       =>$request->input('duration')
            ];
        $risk = new Risk();
        foreach ($data as $key => $value) {
            $risk->$key = $value;
        }
        $father_id = $request->input('father_id', '');
        if($request['isSub'] == null){
            $risk->type = 1;
            $risk->father_id = null;
        } else {
            $risk->type = 2;
            $parent = Risk::find($father_id);
            $risk->parentRisk()->associate($parent);
        }
        $risk->save();
        return redirect()->route('riskmanager.risktask.indexRiskM');
    }
    public function storePortM(StoreRiskRequest $request)
    {
        $data = [
            'name'           =>$request->input('name'),
            'description'    =>$request->input('description'),
            'state'          =>'Creado',
            'factor'         =>$request->input('factor'),
            'type_risk'      =>'Creado',
            'impact'         =>$request->input('impact'),
            'probability'    =>$request->input('probability'),
            'importance'     =>$request->input('importance'),
            'cost'           =>$request->input('cost'),
            'duration'       =>$request->input('duration')
            ];
        $risk = new Risk();
        foreach ($data as $key => $value) {
            $risk->$key = $value;
        }
        $father_id = $request->input('father_id', '');
        if($request['isSub'] == null){
            $risk->type = 1;
            $risk->father_id = null;
        } else {
            $risk->type = 2;
            $parent = Risk::find($father_id);
            $risk->parentRisk()->associate($parent);
        }
        $risk->save();
        return redirect()->route('itemrisk.indexPortM');
    }
    public function showSub($id, $id2)
    {
        $risk = Risk::findOrFail($id2);
        $projects = Project::where('risk_id',$id2);

        return view('internal.risk',["events"=>$events,"category"=>$category]);
    }

    public function edit($id)
    {
        $risk =  Risk::find($id);
        $risk_list = Risk::where('type', '1')->lists('name','id');
        $rbss_list = Rbs::where('type',2)->lists('name','id');
        $riskresponsable_list=User::where('deleted_at',NULL)->lists('name','id');
        $impact_list=Impact::where(["deleted_at"=>NULL])->lists('schedule','id');
        $probability_list=Probability::where(["deleted_at"=>NULL])->lists('description','id');
        $array = [
        'risk'                =>$risk,
        'risk_list'           =>$risk_list,
        'rbss_list'           =>$rbss_list,
        'impact_list'         =>$impact_list,
        'probability_list'    =>$probability_list,
        'riskresponsable_list'=>$riskresponsable_list
        ];

        return view('internal.projectmanager.editCatalog', $array);
    }

    public function editImpact($id)
    {
        $riskmanager_id = Auth::user()->id;

        $impact =  Impact::find($id);
        $array = [
        'impact'            =>$impact,
        'riskmanager_id'    =>$riskmanager_id
        ];

        return view('internal.riskmanager.editImpact', $array);
    }

    public function editProbability($id)
    {
        $riskmanager_id = Auth::user()->id;

        $probability =  Probability::find($id);
        $array = [
        'probability'       =>$probability,
        'riskmanager_id'    =>$riskmanager_id
        ];

        return view('internal.riskmanager.editProbability', $array);
    }

    public function editRisklevel($id)
    {
        $riskmanager_id   = Auth::user()->id;
        $probability_list = Probability::where('deleted_at',NULL)->lists('value','id');
        $impact_list      = Impact::where('deleted_at',NULL)->lists('value','id');
        $risklevel =  Risklevel::find($id);
        $array = [
        'risklevel'         =>$risklevel,
        'riskmanager_id'    =>$riskmanager_id,
        'probability_list' =>$probability_list,
        'impact_list'      =>$impact_list
        ];

        return view('internal.riskmanager.editRisklevel', $array);
    }

    public function editRiskM($id)
    {
        $risk =  Risk::find($id);
        $risk_list = Risk::where('type', '1')->lists('name','id');
        $rbss_list = Rbs::where('type',2)->lists('name','id');
        $riskresponsable_list=User::where('deleted_at',NULL)->lists('name','id');
        $impact_list=Impact::where(["deleted_at"=>NULL])->lists('schedule','id');
        $probability_list=Probability::where(["deleted_at"=>NULL])->lists('description','id');
        $array = [
        'risk'                =>$risk,
        'risk_list'           =>$risk_list,
        'rbss_list'           =>$rbss_list,
        'impact_list'         =>$impact_list,
        'probability_list'    =>$probability_list,
        'riskresponsable_list'=>$riskresponsable_list
        ];

        return view('internal.riskmanager.editCatalog', $array);
    }

    public function editPortM($id)
    {
        $risk =  Risk::find($id);
        $risk_list = Risk::where('type', '1')->lists('name','id');
        $rbss_list = Rbs::where('type',2)->lists('name','id');
        $riskresponsable_list=User::where('deleted_at',NULL)->lists('name','id');
        $impact_list=Impact::where(["deleted_at"=>NULL])->lists('schedule','id');
        $probability_list=Probability::where(["deleted_at"=>NULL])->lists('description','id');
        $array = [
        'risk'                =>$risk,
        'risk_list'           =>$risk_list,
        'rbss_list'           =>$rbss_list,
        'impact_list'         =>$impact_list,
        'probability_list'    =>$probability_list,
        'riskresponsable_list'=>$riskresponsable_list
        ];

        return view('internal.portmanager.editCatalog', $array);
    }

    public function editRiskAnalist($id)
    {
        $risk =  Risk::find($id);
        $risk_list = Risk::where('type', '1')->lists('name','id');
        $rbss_list = Rbs::where('type',2)->lists('name','id');
        $array = [
        'risk'              =>$risk,
        'risk_list'         =>$risk_list,
        'rbss_list'         =>$rbss_list
        ];

        return view('internal.analist.editCatalog', $array);
    }

    public function check($id)
    {
        $risk =  Risk::find($id);
        $risk_list = Risk::where('type', '1')->lists('name','id');
        $rbss_list = Rbs::where('type',2)->lists('name','id');
        $check_list= Checklist::where('deleted_at',NULL)->get();
        $risk_selected=[];
        $array = [
        'risk'              =>$risk,
        'risk_list'         =>$risk_list,
        'rbss_list'         =>$rbss_list,
        'check_list'        =>$check_list,
        'risk_selected'     =>$risk_selected
        ];

        return view('internal.projectmanager.checkCatalog', $array);
    }
    public function checkPost(StoreRiskRequest $request)
    {    $father_id = $request->input('id');
    /*
        var_dump($father_id);
        die();*/
        $data = [
            'name'           =>$request->input('name')
            ];
        
        foreach ($data as $key => $value) {
            $risk = new Risk();
            $risk->$key = $value;
             $risk->type = 2;
        $parent = Risk::find($father_id);
        $risk->parentRisk()->associate($parent);
        
        $risk->save();
        }
       
       
        return redirect()->route('projectManager.task.index');
    }

    public function checkRiskM($id)
    {
        $risk =  Risk::find($id);
        $risk_list = Risk::where('type', '1')->lists('name','id');
        $rbss_list = Rbs::where('type',2)->lists('name','id');
        $array = [
        'risk'              =>$risk,
        'risk_list'         =>$risk_list,
        'rbss_list'         =>$rbss_list
        ];

        return view('internal.riskmanager.checkCatalog', $array);
    }

    public function checkPostRiskM(StoreRiskRequest $request)
    {
        $data = [
            'name'           =>$request->input('name')
            ];
        $risk = new Risk();
        foreach ($data as $key => $value) {
            $risk->$key = $value;
        }
        $father_id = $request->input('father_id', '');
        if($request['isSub'] == null){
            $risk->type = 1;
            $risk->father_id = null;
        } else {
            $risk->type = 2;
            $parent = Risk::find($father_id);
            $risk->parentRisk()->associate($parent);
        }
        $risk->save();
        return redirect()->route('riskmanager.risktask.indexRiskM');
    }

    public function checkPortM($id)
    {
        $risk =  Risk::find($id);
        $risk_list = Risk::where('type', '1')->lists('name','id');
        $rbss_list = Rbs::where('type',2)->lists('name','id');
        $array = [
        'risk'              =>$risk,
        'risk_list'         =>$risk_list,
        'rbss_list'         =>$rbss_list
        ];

        return view('internal.portmanager.checkCatalog', $array);
    }
    public function risklevelSearch(Risk $risk){
        $impact=$risk->impact;
        $probability=$risk->levelprobability;
        $risklevels=Risklevel::where(["deleted_at"=>NULL])->get();
        foreach($risklevels as $risklevel){
          $max=$risklevel->maxProbability;
            if($impact>=$risklevel->minImpact && $impact<=$risklevel->maxImpact && $probability>=$risklevel->minProbability && $probability<=$max){
                echo $risklevel->description;
                return $risklevel->description;
            }
        }

    }
    public function update(UpdateRiskRequest $request, $id)
    {   
        $risk = Risk::find($id);
        $risklevel= $this->risklevelSearch($risk);
        $data = [
            'name'            =>$request->input('name',''),
            'description'     =>$request->input('description',''),
            'state'           =>$request->input('state',''),
            'factor'          =>$request->input('factor',''),
            'type_risk'       =>$request->input('type_risk',''),
            'impact'          =>$request->input('impact',''),
            'probability'     =>$request->input('probability'),
            'levelprobability'=>$request->input('levelprobability'),
            'importance'      =>$risklevel,
            'cost'            =>$request->input('cost',''),
            'duration'        =>$request->input('duration','')
        ];
        
        foreach ($data as $key => $value) {
            if($value!='')
                $risk->$key = $value;
        }

        $father_id = $request->input('father_id', '');
        $riskresponsable_id = $request->input('riskresponsable_id', '');
        if($risk->father_id){
            $risk->type = 2;
            $risk->father_id = $father_id;
            $risk->riskresponsable_id = $riskresponsable_id;
        }
        $risk->save();
        return redirect()->route('projectManager.task.index');
    } 

    public function updateImpact(UpdateImpactRequest $request, $id)
    {
        $data = [
            'schedule'          =>$request->input('schedule',''),
            'cost'              =>$request->input('cost',''),
            'value'             =>$request->input('value','')
        ];
        $impact = Impact::find($id);
        foreach ($data as $key => $value) {
            if($value!='')
                $impact->$key = $value;
        }
        $impact->save();
        return redirect()->route('riskmanager.impact.indexImpact');
    } 

    public function updateProbability(UpdateProbabilityRequest $request, $id)
    {
        $data = [
            'description'       =>$request->input('description',''),
            'value'             =>$request->input('value','')
        ];
        $probability = Probability::find($id);
        foreach ($data as $key => $value) {
            if($value!='')
                $probability->$key = $value;
        }
        $probability->save();
        return redirect()->route('riskmanager.probability.indexProbability');
    } 

    public function updateRisklevel(UpdateRisklevelRequest $request, $id)
    {
        $data = [
            'minProbability'       =>$request->input('minProbability',''),
            'maxProbability'       =>$request->input('maxProbability',''),
            'minImpact'            =>$request->input('minImpact',''),
            'maxImpact'            =>$request->input('maxImpact',''),
            'description'          =>$request->input('description','')
        ];
        $risklevel = Risklevel::find($id);
        foreach ($data as $key => $value) {
            if($value!='')
                $risklevel->$key = $value;
        }
        $risklevel->save();
        return redirect()->route('riskmanager.risklevel.indexRisklevel');
    } 
     public function updateRiskAnalist(UpdateRiskRequest $request, $id)
    {
        $risk = Risk::find($id);
        $risklevel= $this->risklevelSearch($risk);
        $data = [
            'name'            =>$request->input('name',''),
            'description'     =>$request->input('description',''),
            'state'           =>$request->input('state',''),
            'factor'          =>$request->input('factor',''),
            'type_risk'       =>$request->input('type_risk',''),
            'impact'          =>$request->input('impact',''),
            'probability'     =>$request->input('probability'),
            'levelprobability'=>$request->input('levelprobability'),
            'importance'      =>$risklevel,
            'cost'            =>$request->input('cost',''),
            'duration'        =>$request->input('duration','')
        ];
     
        foreach ($data as $key => $value) {
            if($value!='')
                $risk->$key = $value;
        }

        $father_id = $request->input('father_id', '');
        if($risk->father_id){
            $risk->type = 2;
            $risk->father_id = $father_id;
            $risk->riskresponsable_id = $riskresponsable_id;
        }
        $risk->save();
        return redirect()->route('analist.taskrisk.indexAnalist');
    } 

    public function updateRiskM(UpdateRiskRequest $request, $id)
    {
        $risk = Risk::find($id);
        $risklevel= $this->risklevelSearch($risk);
        $data = [
            'name'            =>$request->input('name',''),
            'description'     =>$request->input('description',''),
            'state'           =>$request->input('state',''),
            'factor'          =>$request->input('factor',''),
            'type_risk'       =>$request->input('type_risk',''),
            'impact'          =>$request->input('impact',''),
            'probability'     =>$request->input('probability'),
            'levelprobability'=>$request->input('levelprobability'),
            'importance'      =>$risklevel,
            'cost'            =>$request->input('cost',''),
            'duration'        =>$request->input('duration','')
        ];
        foreach ($data as $key => $value) {
            if($value!='')
                $risk->$key = $value;
        }

        $father_id = $request->input('father_id', '');
        $riskresponsable_id = $request->input('riskresponsable_id', '');
        if($risk->father_id){
            $risk->type = 2;
            $risk->father_id = $father_id;
            $risk->riskresponsable_id = $riskresponsable_id;
        }
        $risk->save();
        return redirect()->route('riskmanager.risktask.indexRiskM');
    } 

     public function updatePortM(UpdateRiskRequest $request, $id)
    {
        $risk = Risk::find($id);
        $risklevel= $this->risklevelSearch($risk);
        $data = [
            'name'            =>$request->input('name',''),
            'description'     =>$request->input('description',''),
            'state'           =>$request->input('state',''),
            'factor'          =>$request->input('factor',''),
            'type_risk'       =>$request->input('type_risk',''),
            'impact'          =>$request->input('impact',''),
            'probability'     =>$request->input('probability'),
            'levelprobability'=>$request->input('levelprobability'),
            'importance'      =>$risklevel,
            'cost'            =>$request->input('cost',''),
            'duration'        =>$request->input('duration','')
        ];
        foreach ($data as $key => $value) {
            if($value!='')
                $risk->$key = $value;
        }

        $father_id = $request->input('father_id', '');
        $riskresponsable_id = $request->input('riskresponsable_id', '');
        if($risk->father_id){
            $risk->type = 2;
            $risk->father_id = $father_id;
            $risk->riskresponsable_id = $riskresponsable_id;
        }
        $risk->save();
        return redirect()->route('portmanager.itemrisk.indexPortM');
    } 
    public function destroy($id)
    { 
        $risk = Risk::find($id); 
        $subrisks = $this->getsubrisks($id)->toArray();
        if(!empty($subrisks)){ 
            $errors = ['El catalogo tiene riesgos'];
            return redirect()->back()->withErrors($errors);
        }
        if (!is_null($risk)) {
            $risk->delete();
        }
        $risk->delete();
    
        return redirect()->route('projectManager.task.index');
    }

    public function destroyProbability($id)
    { 
        $probability = Probability::find($id); 
        $probability->delete();
    
        return redirect()->route('riskmanager.probability.indexProbability');
    }

    public function destroyImpact($id)
    { 
        $impact = Impact::find($id); 
        $impact->delete();
    
        return redirect()->route('riskmanager.impact.indexImpact');
    }

    public function destroyRisklevel($id)
    { 
        $risklevel = Risklevel::find($id); 
        $risklevel->delete();
    
        return redirect()->route('riskmanager.risklevel.indexRisklevel');
    }
    public function destroyRiskM($id)
    { 
        $risk = Risk::find($id); 
        $subrisks = $this->getsubrisks($id)->toArray();
        if(!empty($subrisks)){ 
            $errors = ['El catalogo tiene riesgos'];
            return redirect()->back()->withErrors($errors);
        }
        if (!is_null($risk)) {
            $risk->delete();
        }

    
        return redirect()->route('riskmanager.risktask.indexRiskM');
    }

    public function destroyPortM($id)
    { 
        $risk = Risk::find($id); 
        $subrisks = $this->getsubrisks($id)->toArray();
        if(!empty($subrisks)){ 
            $errors = ['El catalogo tiene riesgos'];
            return redirect()->back()->withErrors($errors);
        }
        if (!is_null($risk)) {
            $risk->delete();
        }

    
        return redirect()->route('portmanager.itemrisk.indexPortM');
    }


    public function getsubrisks($risk_id){
        return Risk::where('father_id', $risk_id)->get();
    } 

    public function indexCheck()
    {
        $checklists = Checklist::where('deleted_at',NULL)->paginate(10);
        return view('internal.admin.checklists', ['checklists' => $checklists]);
    }

    
    public function createCheck()
    {
        $checklist = Checklist::where('deleted_at', NULL)->lists('question','id');
        $rbss_list       = Rbs::where('type',2)->lists('name','id');
        return view('internal.admin.newChecklist',['checklist' => $checklist,'rbss_list' => $rbss_list]);
    }
    public function storeCheck(StoreChecklistRequest $request)
    {
        $data = [
            'rbs_id'          =>$request->input('rbs_id'),
            'question'        =>$request->input('question'),
            'risk'            =>$request->input('risk'),

            ];
        $checklist = new Checklist();
        foreach ($data as $key => $value) {
            $checklist->$key = $value;
        }
        $checklist->save();
        return redirect()->route('admin.checklistItems.index');
    }

    public function editCheck($id)
    {
        $checklist =  Checklist::find($id);
        $rbss_list =  Rbs::where('type',2)->lists('name','id');
        return view('internal.admin.editChecklist', ['checklist' => $checklist,'rbss_list' => $rbss_list]);
    }

    public function updateCheck(UpdateChecklistRequest $request, $id)
    {
        $data = [
            'rbs_id'          =>$request->input('rbs_id'),
            'question'        =>$request->input('question'),
            'risk'            =>$request->input('risk'),
        ];
        $checklist = Checklist::find($id);
        foreach ($data as $key => $value) {
            if($value!='')
                $checklist->$key = $value;
        }
        $checklist->save();
        return redirect()->route('admin.checklistItems.index');
    } 

    public function destroyCheck($id)
    { 
        $checklist = Checklist::find($id); 
        $checklist->delete();
    
        return redirect()->route('admin.checklistItems.index');
    }
}

