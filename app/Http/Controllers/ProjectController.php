<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Requests\UpdateDistributionRequest;
use App\Http\Requests\StoreDistributionRequest;
use App\Http\Requests\AnalyseRequest;
use App\Models\Project;
use App\Models\Typedistribution;
use App\Models\Distribution;
use App\Models\Variable;
use App\Models\Iterations;
use Auth;
use App\Models\Risk;
use App\Models\Result;
use App\Models\Ztable;
use App\Services\FileService;
use gburtini\Distributions\Beta;
use DateTime;
use Carbon\Carbon;
use App\User;
use \stdClass;

class ProjectController extends Controller
{ 
     protected $travelTimes;


    public function __construct(){
        $this->file_service = new FileService();
        
    } 
    public function index()
    {
         $id = Auth::user()->id;
        $projects = Project::where(["projectmanager_id"=>$id,"type" =>'1'])->paginate(10);
        $subcat_list = [];
        foreach ($projects as $project) {
            $subcat_list[$project->name] = $this->getsubactivities($project->id);
        }
    
        return view('internal.projectmanager.projects', ['projects' => $projects, 'subactivities' => $subcat_list]);
    }

    public function indexPort()
    {
        $id = Auth::user()->id;
        $projects = Project::where('type',1)->paginate(10);
        $subcat_list = [];
        $porproject_list = [];
        //Poner solo los proyectos que le corresponde
        foreach ($projects as $project) {
            $subcat_list[$project->name] = $this->getsubactivities($project->id);
        }

        foreach ($projects as $project) {
            //if($project->portmanager_id==$id)
            $porproject_list[$project->name] = $project;
        }
    
        return view('internal.portmanager.projects', ['projects' => $projects, 'subactivities' => $subcat_list,'portprojects'=>$porproject_list]);
    }

    public function indexAnalist()
    {
        $id = Auth::user()->id;
        $projects = Project::where(["analist_id"=>$id,"type" =>'2'])->paginate(10);
        $subcat_list = [];
        $porproject_list = [];
        //Poner solo los proyectos que le corresponde
        foreach ($projects as $project) {
            $subcat_list[$project->name] = $this->getsubactivities($project->id);
        }

        foreach ($projects as $project) {
            if($project->analist_id==$id)
            $porproject_list[$project->name] = $project;
        }
    
        return view('internal.analist.projects', ['projects' => $projects, 'subactivities' => $subcat_list,'portprojects'=>$porproject_list]);
    }
    public function setTravelTimes($id,array $travelTimes) {
        $subactivities=Project::where('father_id', $id)->get();
        $project =  Project::find($id);
        $i=0; 

            foreach ($subactivities as $subactivity) {
                $travelTimes[$i] = $subactivity->Duration; $i++;
            }
        
        foreach ($travelTimes as $t) {
            if (!is_int($t)) {
                throw new InvalidArgumentException("invalid member");
            }
        }
        $this->travelTimes = $travelTimes;
    }

    
    public function triangularDistribution($min, $mode, $max){       
       // $random=rand(0.0,1.0);
        $random = mt_rand() / mt_getrandmax();

        if ($random==(($mode - $min)/($max - $min))){
            return $mode;
        }
        elseif ($random < (($mode - $min)/($max - $min)))
        {
            return $min + sqrt($random * ($max - $min) * ($mode - $min));
        }
        else{
             return $max - sqrt((1 - $random) * ($max - $min) * ($max - $mode));
        }
    }

    public function simulateNormal($id){
        
        $subactivities=Project::where('father_id', $id)->get();
        $project =  Project::find($id);
        $catalogs= Risk::where('father_id', $project->risk_id)->get();
        $risk=[];
        $i=0;

        foreach ($catalogs as $catalog) {
            $risk[$i]= $catalog->cost * ( 0 + mt_rand() / mt_getrandmax() * ($catalog->probability));
            $i++;
        }

          return ($risk);
    }

    public function simulateTriangularTime($id){
        
        $subactivities=Project::where('father_id', $id)->get();
        $project =  Project::find($id);
        $risks = Risk::where('father_id',$project->risk_id)->get();
        $duration=0;
        $duration=$this->criticRouteTriangular($id);     

        foreach($risks as $risk){
            if($risk->duration !=NULL){
              $minProb= mt_rand(0, $risk->probability-1);
              $maxProb= mt_rand($risk->probability+1, 100);
              $Prob   = $risk->probability;    
              $duration= $duration + $this->triangularDistribution($risk->duration * $minProb/100, $risk->duration * $Prob/100,$risk->duration * $maxProb/100 );
             }
        }
          return array($duration);
    }

    public function simulateTriangular($id){
        
        $subactivities=Project::where('father_id', $id)->get();
        $project =  Project::find($id);
        $risks = Risk::where('father_id',$project->risk_id)->get();
        $cost=0;
        foreach ($subactivities as $subactivity) {    
            $cost= $subactivity->cost + $cost;
        }

        foreach($risks as $risk){
            if($risk->cost !=NULL){
              $minProb= mt_rand(0, $risk->probability-1);
              $maxProb= mt_rand($risk->probability+1, 100);
              $Prob   = $risk->probability;    
              $cost= $cost + $this->triangularDistribution($risk->cost * $minProb/100, $risk->cost * $Prob/100,$risk->cost * $maxProb/100 );
             }
        }

          return array($cost);
    }

    public function Normal($value,$z_values,$media,$std){
        if($std!=0)
        $z_value = round(($value - $media)/$std,2);     
/*
        $percent=$this->culmative($value,$std);
        return $percent;*/
        
        foreach($z_values as $z){
          
            if($z->value==$z_value) {
               
                return $z->percent;
            }
        }
     return 0;
    }

    public function absoluteRiskCost($risk){
       
       $cost=0;
        
        for($i=1;$i<count($risk);$i++){
          
            $cost+=$risk[$i];
        }
     return $cost;
    }

    public function runCheckPlanRiskNormal($id,$numtrials) {
        $costPerfect = 0;
        $result=[];
        $frecuencyresult=[];
        $subactivities=Project::where('father_id', $id)->get();

        $uniqueresults=[];
        $min=0;
        $max=0;
        $normalcost=0;

        foreach ($subactivities as $subactivity) {
            $min= $subactivity->minCost + $min;
        }
        foreach ($subactivities as $subactivity) {
            $max= $subactivity->maxCost + $max;
        }
         foreach ($subactivities as $subactivity) {
            $normalcost= $subactivity->cost + $normalcost;
        }

        $z_values= Ztable::where('key',0)->get();
        for ($i = 1; $i <= $numtrials; $i++) {
            $cost_risk           =  $this->simulateNormal($id); // Array of costs (Risks)
            $total_riskcost      =  $this->absoluteRiskCost($cost_risk);
            $uniqueresults[$i]   = $normalcost + $total_riskcost; // /100
        }


            $media               = $this->mean($uniqueresults);
            $std                 = $this->std($uniqueresults);
           // $frecuencyresult[$i] = $this->Normal($total_riskcost,$z_values,$media,$std);

        for ($i=1;$i<count($uniqueresults);$i++){
            $frecuencyresult[$i]  = $this->Normal($uniqueresults[$i],$z_values,$media,$std);
        }    

        $frecuencyArray=[];
        $uniqueArray=[];
        $i=1;        $j=1;
        foreach ($frecuencyresult as $frecuency) {
            $frecuencyArray[$i]=$frecuency;
            $i++;
        }
        foreach ($uniqueresults as $unique) {
            $uniqueArray[$i]=$unique;
            $i++;
        }
        for($i=1; $i < count($uniqueresults); $i++){
            $result= new Result();
            $data = [
            'project_id'    =>$id,
            'cost'          =>$uniqueresults[$i],
            'percent'       =>$frecuencyresult[$i]
            ];
            foreach ($data as $key => $value) {
            $result->$key = $value;
        }  
            $result->save();
            
        }
        return($result);
    }
     public function runCheckPlanRiskTrian($id,$numTrials) {
        $project =  Project::find($id);
        $results=[];
        $result=[];
        $frecuencyresult=[];
        $uniqueresults=[];
        for ($i = 1; $i <= $numTrials; $i++) {
            $results = $this->simulateTriangular($id);
            $resultArray[$i]   = intval(round($results[0]));
        }


        $frecuencyresult = array_count_values($resultArray);
        $uniqueresults=array_unique($resultArray);
        $frecuencyArray=[];
        $uniqueArray=[];
        $i=1;        $j=1;
        foreach ($frecuencyresult as $frecuency) {
            $frecuencyArray[$i]=$frecuency;
            $i++;
        }
        foreach ($uniqueresults as $unique) {
            $uniqueArray[$j]=$unique;
            $j++;
        }
        for($i=1; $i <= count($uniqueresults); $i++){
            $result= new Result();
            $data = [
            'project_id'    =>$id,
            'cost'          =>$uniqueArray[$i],
            'percent'       =>round(($frecuencyArray[$i]/count($resultArray))*100,2)
            ];
            foreach ($data as $key => $value) {
            $result->$key = $value;
        }  /*
            $result->project_id=$id;
            $result->cost=$uniqueArray[$i];

            $percent=round($frecuencyArray[$i]/count($resultArray),2);
            $result->percent=$percent;*/
            $result->save();
            
        }

        return($result);


    }
     public function runCheckPlanRiskTrianTime($id,$numTrials) {
        $project =  Project::find($id);
        $results=[];
        $result=[];
        $frecuencyresult=[];
        $uniqueresults=[];
        for ($i = 1; $i <= $numTrials; $i++) {
            $results = $this->simulateTriangularTime($id);
            $resultArray[$i]   = intval(round($results[0]));
        }


        $frecuencyresult = array_count_values($resultArray);
        $uniqueresults=array_unique($resultArray);
        $frecuencyArray=[];
        $uniqueArray=[];
        $i=1;        $j=1;
        foreach ($frecuencyresult as $frecuency) {
            $frecuencyArray[$i]=$frecuency;
            $i++;
        }
        foreach ($uniqueresults as $unique) {
            $uniqueArray[$j]=$unique;
            $j++;
        }
        for($i=1; $i <= count($uniqueresults); $i++){
            $result= new Result();
            $data = [
            'project_id'    =>$id,
            'cost'          =>$uniqueArray[$i], //Value
            'percent'       =>round(($frecuencyArray[$i]/count($resultArray)),2)
            ];
            foreach ($data as $key => $value) {
            $result->$key = $value;
        }  /*
            $result->project_id=$id;
            $result->cost=$uniqueArray[$i];

            $percent=round($frecuencyArray[$i]/count($resultArray),2);
            $result->percent=$percent;*/
            $result->save();
            
        }

        return($result);


    }
        
/* Media */
function mean($input_array)
{ 
  $total = 0;
  for($i=1;$i<count($input_array);$i++)
  { 
    $total = $total + $input_array[$i];

  }

  if (count($input_array)!=0)
  return ($total / count($input_array));
}

/* Standard Deviation */
function std($arr)
{
  if (!count($arr))
  return 0;
  $mean = $this->mean($arr);
  $sos = 0; // Sum of squares

  for ($i = 1; $i < count($arr); $i++)
  {
    $sos = $sos + ($arr[$i] - $mean) * ($arr[$i] - $mean);
  }


  if((count($arr) - 1)!=0)

  return sqrt($sos / (count($arr)));
}

function variance($arr)
{

return pow($this->std($arr),2);

}

public function culmative($x, $std){
    $culmative=0;
    $a1=0.319381530;
    $a2=-0.356563782;
    $a3=1.781477937;
    $a4=-1.821255978;
    $a5=1.330274429;

    $k=1.0/(1.0 +0.2316419*$x/$std);
    if($x>=0.0){
        $culmative=1.0 - $this->n($x,$std)*($a1*$k+ $a2*pow($k,2) + $a3*pow($k,3) + $a4*pow($k,4) + $a5*pow($k,5));
    }
    else {
        $culmative=1.0 - $this->culmative(-$x,$std);
    }
    return $culmative;
}

public function n($x, $std){

    return  exp(-$x*$x/(2*$std*$std)) / (sqrt(2.0*pi()*$std*$std));

} 
protected static function erf($x) {
                // translation of Press, Teukolsky, Vetterling, Flannery (2001) approximation.
                // https://en.wikipedia.org/wiki/Error_function#Numerical_approximation
            $t = 1 / (1 + 0.5 * abs($x));
            $tau = $t * exp(
                    - $x * $x
                    - 1.26551223
                    + 1.00002368 * $t
                    + 0.37409196 * pow($t, 2)
                    + 0.09678418 * pow($t, 3)
                    - 0.18628806 * pow($t, 4)
                    + 0.27886807 * pow($t, 5)
                    - 1.13520398 * pow($t, 6)
                    + 1.48851587 * pow($t, 7)
                    - 0.82215223 * pow($t, 8)
                    + 0.17087277 * pow($t, 9));

            if ($x >= 0) {
                return 1 - $tau;
            } else {
                return $tau - 1;
            }
        }
// variance = standar derivation ^2

     /*NORMAL DISTRIBUTION*/
     public function pdf($xs) {
            //$z = ($x - $this->mean)/$this->variance;
        $total=0;
        foreach($xs as $x){
                $z =pow(($x - $this->mean($xs)),2)/$this->variance($xs);
               // echo $this->variance($xs) * M_SQRTPI * M_SQRT2;
               $total=$total + exp(-$z*$z/2) / ( $this->std($xs) * M_SQRTPI * M_SQRT2);

            }

                return $total;
        }
      public function cdf($xs) {

         $total=0;
         $mean= $this->mean($xs);
         $variance = $this->variance($xs);
         foreach($xs as $x){
                $d = $x - $mean;

               $total=$total + 0.5 * (1 + $this->erf($d / (sqrt($variance) * sqrt(2))));
            }
                return $total;
               // return 0.5 * (1 + $this->erf($d / (sqrt($this->variance) * sqrt(2))));
      }



    protected function check($id,$travelTime, $tiresDelay) {
        // find the total schedule baseline
        
        $subactivities=Project::where('father_id', $id)->get();
        $project =  Project::find($id);
        $risk=Risk::find($project->risk_id);
        $risks=Risk::where('father_id', $project->risk_id)->get();
        $travelTime = 0;
        foreach ((array)$this->travelTimes as $t) {
            $travelTime += $t * rand(90, 125) / 100;
        }

       //risks here?
        $tiresDelay = 0;
         
         foreach ($risks as $r) {
            if (rand(1, 100) > 50) {
                $tiresDelay = $r->duration * rand(90, 125) / 100 + $tiresDelay;
            }
        }
        
       // echo "costo Riesgo $tiresDelay \n\n";
        $time = 0;
        // ditto for checking tires
        foreach ($subactivities as $subactivity) {
            $time= $subactivity->Duration + $time;
        }

        
        $meetingArriveTime =floor((abs(strtotime($project->initialDate))))/(60*60*24) +  $travelTime + $time + $tiresDelay;
        $meetingTime=floor((abs(strtotime($project->finalDate))))/(60*60*24);
       // echo "meetingArriveTime: " . $newformat = date('Y-m-d',($meetingArriveTime*(60*60*24))) ;
       // echo "meetingTime: " . $newformat = date('Y-m-d',($meetingTime*(60*60*24))) ;
       // echo "meetingArriveTime $meetingArriveTime";
       //echo "meetingTime $meetingTime";
        $arriveOnTime = $meetingArriveTime <= $meetingTime;

        return array($meetingArriveTime, $meetingTime, $arriveOnTime);
    }


   public function checkPlanRisk() {
        // adjust and sum travel times between milestones(duration in days, % best = 90 (10-),worst=125 (+) )
        $travelTime = 0;
        $tiresDelay = 0;
        $result = $this->check(1,$travelTime, $tiresDelay);
        return array_merge(array($tiresDelay), $result);
    }
    /*THIS IS NORMAL DISTRIBUTION*/

    public function runCheckPlanRisk() {
        $arriveOnTime = 0;
        $numTrials=20;
        for ($i = 1; $i <= $numTrials; $i++) {
            $result = $this->checkPlanRisk();
            $this->tiresDelay=0;
            if ($result[3]) {
                $arriveOnTime++;
            }

           // echo "Intento: " . $i ;
           // echo " Duración de Proyecto: " . $result[1];
           // echo " Tiempo que se esperaba: " . $result[2];
            

            if ($result[3]) {
             //   echo " -- Proyecto terminado en tiempo";
            }
            else {
              //   echo " -- Proyecto terminado tarde";
            }

            $confidence = $arriveOnTime / $i;
           // echo "\nConfidence level: $confidence\n\n";
        }
    }

    public  function criticRoute($id){
     
        $project = Project::find($id);
        $subactivities = Project::where('father_id',$id)->get();

        $initial_id=0;
        foreach($subactivities as $subactivity){
            if($subactivity->dependence_id==NULL){
                $initial_id=intval($subactivity->id);
            }
        }
        $max=0; $sons=0;
        $initialActivity=Project::find($initial_id);
        $first=$initialActivity->id;
        $suma=$initialActivity->Duration;

         foreach ($subactivities as $subactivity) {
            if($subactivity->dependence_id==$initial_id ){
                    $sons++;
            }
        }

        if ($sons!=0){
        $criticalpath=$this->maxTime($sons,$initialActivity,$max,$suma,$subactivities);
        }else{
          $max=$suma;  
        }
        
        return $max;
    }

    public  function criticRouteTriangular($id){
       
        $project = Project::find($id);
        $subactivities = Project::where('father_id',$id)->get();

        $initial_id=0;
        foreach($subactivities as $subactivity){
            if($subactivity->dependence_id==NULL){
                $initial_id=intval($subactivity->id);
            }
        }
        $max=0; $sons=0;
        $initialActivity=Project::find($initial_id);
        

        $suma=$this->triangularDistribution($initialActivity->minDuration, $initialActivity->Duration,$initialActivity->maxDuration);

         foreach ($subactivities as $subactivity) {
            if($subactivity->dependence_id==$initial_id ){
                    $sons++;
            }
        }

        if ($sons!=0){
        $criticalpath=$this->maxTimeTriangular($sons,$initialActivity,$max,$suma,$subactivities);
        }else{
          $max=$suma;  
        }
        
        return $max;
    }

    public function maxTimeTriangular($sons,&$initial_id, &$max, &$suma,$subactivities){

        $sons=1;
        $paths=[];
        $id=  $initial_id->id;
        foreach ($subactivities as $subactivity) {

            if($subactivity->dependence_id==$id ){
                $paths[$sons]=$subactivity;
                $sons++;
      
            }
        }
        
        foreach ($paths as $path) {
            $trianSuma=$this->triangularDistribution($path->minDuration, $path->Duration,$path->maxDuration);
            $suma=$suma+$trianSuma;
            //echo "Path".$suma;
            if($suma>$max){
                $max=$suma;
              //  echo "Path".$path->duration;
               // echo "Suma".$suma;
            }
            $this->maxTime($sons,$path,$max,$suma,$subactivities);
            $suma=$suma-$trianSuma;
        }
        return $max;
    }

    public function maxTime($sons,&$initial_id, &$max, &$suma,$subactivities){

        $sons=1;
        $paths=[];
        $id=  $initial_id->id;
        foreach ($subactivities as $subactivity) {

            if($subactivity->dependence_id==$id ){
                $paths[$sons]=$subactivity;
                $sons++;
      
            }
        }
        
        foreach ($paths as $path) {
            $suma=$suma+$path->Duration;
            //echo "Path".$suma;
            if($suma>$max){
                $max=$suma;
              //  echo "Path".$path->duration;
               // echo "Suma".$suma;
            }
            $this->maxTime($sons,$path,$max,$suma,$subactivities);
            $suma=$suma-$path->Duration;
        }
        return $max;
    }

    public function indexSub($id)
    {
        $project = Project::findOrFail($id);
        $subactivities_pure = Project::where('father_id',$id)->get();

        $subactivities = Project::where('father_id',$id)->paginate(10);
        $subactivities->setPath('subactivities');
        return view('internal.projectmanager.subprojects',['project'=>$project,"subactivities"=>$subactivities]);
    }

    public function indexSubPort($id)
    {
        $project = Project::findOrFail($id);
        $subactivities_pure = Project::where('father_id',$id)->get();

        $subactivities = Project::where('father_id',$id)->paginate(10);
        $subactivities->setPath('subactivities');
        return view('internal.portmanager.subprojects',['project'=>$project,"subactivities"=>$subactivities]);
    }

    public function indexSubAnalist()
    {
       
        $id = Auth::user()->id;
        $subactivities = Project::where(["analist_id"=>$id,"type" =>'2'])->paginate(10);
        //$project
        $subactivities->setPath('subactivities');
        return view('internal.analist.subprojects',["subactivities"=>$subactivities]);
    }

    public function indexSubAdmin($parent_project)
    {   
        $projects = Project::where('father_id',$parent_project)->paginate(5);
        $projects->setPath('subactivities');
        return view('internal.admin.subprojects', ['projects' => $projects]);
    }

    public function create()
    {   $risks_list = Risk::where('type',1)->lists('name','id');
        $project_list = Project::where('type', '1')->lists('name','id');
        $activities_list=Project::where('type','2')->lists('name','id');
        $array = ['risks_list'     =>$risks_list,
                  'activities_list'=>$activities_list,
                  'project_list'   =>$project_list];
     return view('internal.projectmanager.newProject',$array);
    }
   

    public function createPort()
    {   $risks_list = Risk::where('type',1)->lists('name','id');
        $project_list = Project::where('type', '1')->lists('name','id');
        $id = Auth::user()->id;
        $activities_list=Project::where(["portmanager_id"=>$id,"type" =>'2'])->lists('name','id');
        $analist_list=User::where('role_id',5)->lists('name','id');

        
        $pormanager_list=Project::where(["portmanager_id"=>$id,"type" =>'1'])->lists('name','id');
        $array = ['risks_list'     =>$risks_list,
                  'activities_list'=>$activities_list,
                  'project_list'   =>$project_list,
                  'analist_list'   =>$analist_list,
                  'pormanager_list'=>$pormanager_list];
     return view('internal.portmanager.newProject',$array);
    }

    public function store(StoreProjectRequest $request)
    {   

        $date1 = $request->input('initialDate');
        $date2 = $request->input('finalDate');
        $diff = abs(strtotime($date2) - strtotime($date1));
        $days = floor(($diff));
        $data = [
            'name'          =>$request->input('name'),
            'description'   =>$request->input('description'),
            'risk_id'       =>$request->input('risk_id'),
            'initialDate'   => $request->input('initialDate'),
            'finalDate'     => $request->input('finalDate'),
            'Duration'      =>  floor((abs(strtotime($request->input('initialDate')) - strtotime($request->input('finalDate')))))/(60*60*24),
            'state'         =>'Creado',
            'cost'          =>0,
            'minCost'       =>$request->input('minCost'),
            'maxCost'       =>$request->input('maxCost'),
            'maxDuration'   =>$request->input('maxDuration'),
            'minDuration'   =>$request->input('minDuration'),
            'dependence_id' =>$request->input('dependence_id')
            ];

        $project = new Project();
        foreach ($data as $key => $value) {
            $project->$key = $value;
        }
        $father_id = $request->input('father_id', '');
        if($request['isSub'] == null){
            $project->type = 1;
            $project->father_id = null;
        } else {
            $project->type = 2;
            $parent = Project::find($father_id);
            $project->parentProject()->associate($parent);
        }
        $project->save();
        return redirect()->route('projectmanager.projects.index');
    }

    public function storePort(StoreProjectRequest $request)
    {   

        $date1 = $request->input('initialDate');
        $date2 = $request->input('finalDate');
        $diff = abs(strtotime($date2) - strtotime($date1));
        $days = floor(($diff));
        $data = [
            'name'          =>$request->input('name'),
            'description'   =>$request->input('description'),
             'risk_id'       =>$request->input('risk_id'),
             'initialDate'   => $request->input('initialDate'),
             'finalDate'   => $request->input('finalDate'),
             'Duration'=>  floor((abs(strtotime($request->input('initialDate')) - strtotime($request->input('finalDate')))))/(60*60*24),
            'state'           =>'Creado',
            'cost'            =>$request->input('cost'),
            'minCost'         =>$request->input('minCost'),
            'maxCost'         =>$request->input('maxCost'),
            'maxDuration'   =>$request->input('maxDuration'),
            'minDuration'   =>$request->input('minDuration'),
            'dependence_id'   =>$request->input('dependence_id')
            ];

        $project = new Project();
        foreach ($data as $key => $value) {
            $project->$key = $value;
        }
        $father_id = $request->input('father_id', '');
        if($request['isSub'] == null){
            $project->type = 1;
            $project->father_id = null;
        } else {
            $project->type = 2;
            $parent = Project::find($father_id);
            $project->parentProject()->associate($parent);
        }
        $id = Auth::user()->id;
        $project->portmanager_id=$id;
        $project->save();
        return redirect()->route('portmanager.project.indexPort');
    }
    

    public function edit($id)
    {
        $project =  Project::find($id);
        $risks_list = Risk::where('type',1)->lists('name','id');
        if($project->type==2){
        $father_project=$project->father_id;
        $activities_list=Project::where('father_id',$father_project)->lists('name','id');    
        }
        else{
        $activities_list=Project::where('type',2)->lists('name','id');     
        }
        $project_list = Project::where('type', '1')->lists('name','id');
       
        $array = [
        'project'           =>$project,
        'risks_list'        =>$risks_list,
        'project_list'      =>$project_list,
        'activities_list'   =>$activities_list
        ];
        return view('internal.projectmanager.editProject', $array);
    }

    public function createanalyse($id)
    {

        $project =  Project::find($id);
        $iteration_list       =Iterations::where('deleted_at', NULL)->lists('value','id');;
        $typedistribution_list=Typedistribution::where('deleted_at', NULL)->lists('name','id');
        $variable_list        =Variable::where('deleted_at', NULL)->lists('name','id');
        $array = [
        'iteration_list'        =>$iteration_list,
        'typedistribution_list' =>$typedistribution_list,
        'variable_list'         =>$variable_list,
        'project'               =>$project   
        ];

        return view('internal.projectmanager.analyseProject', $array);
    }
    public function editPort($id)
    {
        $project =  Project::find($id);
        $risks_list = Risk::where('type',1)->lists('name','id');
        if($project->type==2){
        $father_project=$project->father_id;
        $activities_list=Project::where('father_id',$father_project)->lists('name','id');    
        }
        else{
        $activities_list=Project::where('type',2)->lists('name','id');     
        }
        $project_list = Project::where('type', '1')->lists('name','id');

        $analist_list=User::where('role_id',5)->lists('name','id');
        $projectmanager_list=User::where('role_id',1)->lists('name','id');
       
        $array = [
        'project'                  =>$project,
        'risks_list'               =>$risks_list,
        'project_list'             =>$project_list,
        'activities_list'          =>$activities_list,
        'analist_list'             =>$analist_list,
        'projectmanager_list'      =>$projectmanager_list

        ];
        return view('internal.portmanager.editProject', $array);
    }

     public function editAnalist($id)
    {
        $project =  Project::find($id);
        $risks_list = Risk::where('type',1)->lists('name','id');
        if($project->type==2){
        $father_project=$project->father_id;
        $activities_list=Project::where('father_id',$father_project)->lists('name','id');    
        }
        else{
        $activities_list=Project::where('type',2)->lists('name','id');     
        }
        $project_list = Project::where('type', '1')->lists('name','id');
       
        $array = [
        'project'           =>$project,
        'risks_list'        =>$risks_list,
        'project_list'      =>$project_list,
        'activities_list'   =>$activities_list
        ];
        return view('internal.analist.editProject', $array);
    }
    public function analyse($id,StoreDistributionRequest  $request)
    {   
        $connection = mysqli_connect('localhost', 'axbravo', 'peppa', 'riesgo');
         mysqli_query( $connection,'TRUNCATE TABLE result');
         $connection = mysqli_connect('localhost', 'axbravo', 'peppa', 'riesgo');
        mysqli_query( $connection,'TRUNCATE TABLE distribution');

        $distribution= new Distribution();
            $data = [
            'project_id'    =>$id,
            'name'          =>$request->input('name',''),
            'iterations'    =>$request->input('iterations',''),
            'variable'      =>$request->input('variable','')
            ];
            foreach ($data as $key => $value) {
            $distribution->$key = $value;
            }  
            $distribution->save();


         return redirect()->route('projectmanager.projects.cuantitative');//view('internal.admin.cuantitativeProject',$id);
    }

    
        public function cuantitative()
    {   //Borrar toda la data
         
        //Calcular todo de nuevo
        $distribution    = Distribution::find(1); 
        $project =  Project::find($distribution->project_id);
        $subactivities=Project::where('father_id', $project->id)->get();

        
        $iteration       = Iterations::find($distribution->iterations);
        $typedistribution= Typedistribution::find($distribution->name);
        $variable        = Variable::find($distribution->variable);
        
        /*TRIANGULAR DISTRIBUTION*/
        if($typedistribution->name=="Triangular" && $variable->name=="Costo"){
        $result=$this->runCheckPlanRiskTrian($project->id,$iteration->value)->lists('cost','id');
         }
        /*NORMAL DISTRIBUTION*/
        if($typedistribution->name=="Normal" && $variable->name=="Costo"){
      
        $result=$this->runCheckPlanRiskNormal($project->id,$iteration->value)->lists('cost','id');
        }

        /*TRIANGULAR DISTRIBUTION*/
        if($typedistribution->name=="Triangular" && $variable->name=="Alcance"){
        $result=$this->runCheckPlanRiskTrianTime($project->id,$iteration->value)->lists('cost','id');
         }
        /*NORMAL DISTRIBUTION*/
        if($typedistribution->name=="Normal" && $variable->name=="Alcance"){
      
        $result=$this->runCheckPlanRiskNormalTime($project->id,$iteration->value)->lists('cost','id');
        }
        $result_list =Result:: where ('project_id',$project->id)->lists('percent','id');

        $min=0;
        $max=0;
        $mode=0;
        foreach ($subactivities as $subactivity) {
            $min= $subactivity->minCost + $min;
        }
        foreach ($subactivities as $subactivity) {
            $max= $subactivity->maxCost + $max;
        }
        foreach ($subactivities as $subactivity) {
            $mode= $subactivity->cost + $mode;
        }


        $array = [
        'project'           =>$project,
        'result_list'       =>$result_list,
        'result'            =>$result,
        'min'               =>$min,
        'max'               =>$max,
        'mode'              =>$mode
        ];

        
         return view('internal.projectmanager.cuantitativeProject', $array);
    }
/*
    public function showSub($id, $id2)
    {
        $project = Project::findOrFail($id2);
        $risks = Risk::where('project_id',$id2);

        return view('internal.project',["risks"=>$risks,"project"=>$project]);
    }
*/

    public function update(UpdateProjectRequest $request, $id)
    {
        $data = [
            'name'          =>$request->input('name',''),
            'description'   =>$request->input('description',''),
            'state'         =>$request->input('state',''),
            'initialDate'   => $request->input('initialDate'),
            'finalDate'   => $request->input('finalDate'),
            'Duration'=>  floor((abs(strtotime($request->input('initialDate')) - strtotime($request->input('finalDate')))))/(60*60*24),
            'risk_id'       => $request->input('risk_id'),
            'minCost'       => $request->input('minCost'),
            'maxCost'       => $request->input('maxCost'),
            'maxDuration'   =>$request->input('maxDuration'),
            'minDuration'   =>$request->input('minDuration'),
            'cost'          => $request->input('cost'),
            'dependence_id' => $request->input('dependence_id')
        ];
        $project = Project::find($id);
        foreach ($data as $key => $value) {
            if($value!='')
                $project->$key = $value;
        }
        $risk_id     = $request->input('risk_id','');
        if($project->risk_id){
            $project->risk_id = $risk_id;
        }

        $father_id = $request->input('father_id', '');
        if($project->father_id){
            $project->type = 2;
            $project->father_id = $father_id;
        }


       /*WROOOOOOOOOONG NO SE ACTUALIZA EL COSTO TOTAL T.T*/
            if($project->type==2){
            $subactivities=Project::where('father_id', $father_id)->get();
            $parent_project=Project::find($project->father_id);
            $parent_project->cost=0;
            foreach ($subactivities as $subactivity) {
                $parent_project->cost= $subactivity->cost + $parent_project->cost;
            }
            }
            if($project->type==1){
            $subactivities=Project::where('father_id', $id)->get();
            $project->cost=0;
            foreach ($subactivities as $subactivity) {
                $project->cost= $subactivity->cost + $project->cost;
            }
           }
            
        
       
        
        $project->save();
        return redirect()->route('projectmanager.projects.index');
    } 

    public function updatePort(UpdateProjectRequest $request, $id)
    {
        $data = [
            'name'          =>$request->input('name',''),
            'description'   =>$request->input('description',''),
            'state'         =>$request->input('state',''),
            'initialDate'   => $request->input('initialDate'),
            'finalDate'   => $request->input('finalDate'),
            'Duration'=>  floor((abs(strtotime($request->input('initialDate')) - strtotime($request->input('finalDate')))))/(60*60*24),
            'risk_id'       => $request->input('risk_id'),
            'minCost'       => $request->input('minCost'),
            'maxCost'       => $request->input('maxCost'),
            'maxDuration'   =>$request->input('maxDuration'),
            'minDuration'   =>$request->input('minDuration'),
            'cost'          => $request->input('cost'),
            'dependence_id' => $request->input('dependence_id')
        ];
        $project = Project::find($id);
        foreach ($data as $key => $value) {
            if($value!='')
                $project->$key = $value;
        }
        $risk_id     = $request->input('risk_id','');
        if($project->risk_id){
            $project->risk_id = $risk_id;
        }

        $father_id = $request->input('father_id', '');
        $analist_id = $request->input('analist_id', '');
        $projectmanager_id = $request->input('projectmanager_id', '');

        if($project->type==1){
            $project->projectmanager_id=$projectmanager_id;
        }

        if($project->father_id){
            $project->type = 2;
            $project->father_id = $father_id;
            $project->analist_id= $analist_id;
        }


       /*WROOOOOOOOOONG NO SE ACTUALIZA EL COSTO TOTAL T.T*/
            if($project->type==2){
            $subactivities=Project::where('father_id', $father_id)->get();
            $parent_project=Project::find($project->father_id);
            $parent_project->cost=0;
            foreach ($subactivities as $subactivity) {
                $parent_project->cost= $subactivity->cost + $parent_project->cost;
            }
            }
            if($project->type==1){
            $subactivities=Project::where('father_id', $id)->get();
            $project->cost=0;
            foreach ($subactivities as $subactivity) {
                $project->cost= $subactivity->cost + $project->cost;
            }
           }
            
        $project->save();
        return redirect()->route('portmanager.project.indexPort');
    } 

     public function updateAnalist(UpdateProjectRequest $request, $id)
    {
        $data = [
            'name'          =>$request->input('name',''),
            'description'   =>$request->input('description',''),
            'state'         =>$request->input('state',''),
            'initialDate'   => $request->input('initialDate'),
            'finalDate'   => $request->input('finalDate'),
            'Duration'=>  floor((abs(strtotime($request->input('initialDate')) - strtotime($request->input('finalDate')))))/(60*60*24),
            'risk_id'       => $request->input('risk_id'),
            'minCost'       => $request->input('minCost'),
            'maxCost'       => $request->input('maxCost'),
            'maxDuration'   =>$request->input('maxDuration'),
            'minDuration'   =>$request->input('minDuration'),
            'cost'          => $request->input('cost'),
            'dependence_id' => $request->input('dependence_id')
        ];
        $project = Project::find($id);
        foreach ($data as $key => $value) {
            if($value!='')
                $project->$key = $value;
        }
        $risk_id     = $request->input('risk_id','');
        if($project->risk_id){
            $project->risk_id = $risk_id;
        }

        $father_id = $request->input('father_id', '');
        if($project->father_id){
            $project->type = 2;
            $project->father_id = $father_id;
        }


       /*WROOOOOOOOOONG NO SE ACTUALIZA EL COSTO TOTAL T.T*/
            if($project->type==2){
            $subactivities=Project::where('father_id', $father_id)->get();
            $parent_project=Project::find($project->father_id);
            $parent_project->cost=0;
            foreach ($subactivities as $subactivity) {
                $parent_project->cost= $subactivity->cost + $parent_project->cost;
            }
            }
            if($project->type==1){
            $subactivities=Project::where('father_id', $id)->get();
            $project->cost=0;
            foreach ($subactivities as $subactivity) {
                $project->cost= $subactivity->cost + $project->cost;
            }
           }
            
        
       
        $id = Auth::user()->id;
        $project->analist_id=$id;
        $project->save();
        return redirect()->route('activity.indexAnalist');
    } 

    public function destroy($id)
    { 
        $project = Project::find($id); 
        $subactivities = $this->getsubactivities($id)->toArray();
        if(!empty($subactivities)){ 
            $errors = ['El proyecto tiene actividades'];
            return redirect()->back()->withErrors($errors);
        }
        if (!is_null($project)) {
            $project->delete();
        }
       // $project->delete();
    
        return redirect()->route('portmanager.project.indexPort');
    }


    public function getsubactivities($project_id){
        return Project::where('father_id', $project_id)->get();
    } 

}

