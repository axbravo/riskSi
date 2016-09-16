<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Risklevel extends Model
{

    protected $table = 'risklevel';
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    

}
