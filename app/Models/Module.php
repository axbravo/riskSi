<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
	use SoftDeletes;
    
	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
	protected $table = 'modules';
    protected $dates = ['deleted_at'];

    protected $fillable = ['name', 'address', 'district', 'province', 'state', 'phone','email','initial_cash',  'actual_cash', 'openModule','starTime','endTime','image'];

    public function users() {
        return $this->hasMany('App\User');
    }
}
