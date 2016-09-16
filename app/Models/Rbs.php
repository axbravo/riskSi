<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rbs extends Model
{

    protected $table = 'rbs';
   use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    public function risk(){
        return $this->belongsTo('App\Models\Risk','risk_id');
    } 
    public function subrbss(){
        return $this->hasMany('App\Models\Rbs','father_id');
    }
   
    public function parentRbs(){
        return $this->belongsTo('App\Models\Rbs', 'father_id');
    }    
}