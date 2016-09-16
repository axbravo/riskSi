<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{

    protected $table = 'project';
   use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function risk(){
        return $this->belongsTo('App\Models\Risk');
    } 
    public function subactivities(){
        return $this->hasMany('App\Models\Project','father_id');
    }
   
    public function parentProject(){
        return $this->belongsTo('App\Models\Project', 'father_id');
    }   
    
    public function parentActivity(){
        return $this->belongsTo('App\Models\Project', 'dependence_id');
    } 

}
