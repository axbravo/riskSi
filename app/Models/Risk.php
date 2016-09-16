<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Risk extends Model
{

    protected $table = 'risk';
   use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function projects() {
        return $this->hasMany('App\Models\Project');
    }
    public function subrisks(){
        return $this->hasMany('App\Models\Risk','father_id');
    }

    public function parentRisk(){
        return $this->belongsTo('App\Models\Risk', 'father_id');
    }  
      
}