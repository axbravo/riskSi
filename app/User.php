<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    protected $dates = ['deleted_at'];

    public function role()
    {
        return $this->belongsTo('App\Role');
    }
    public function module(){
        return $this->belongsTo('App\Models\Module');
    }

     public function analists(){
        return $this->hasMany('App\Models\User','analist_id');
    }
   
    public function portmanagers(){
        return $this->belongsTo('App\Models\User', 'portmanager_id');
    }   
    
    public function riskmanagers(){
        return $this->belongsTo('App\Models\Project', 'riskmanager_id');
    } 

    public function riskresponsables(){
        return $this->belongsTo('App\Models\Project', 'riskresponsable_id');
    } 
}
