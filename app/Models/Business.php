<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $table = 'business';

    public function module(){
    	return $this->belongsTo('App\Models\Module','gift_module_id');
    }
}
