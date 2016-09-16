<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Impact extends Model
{

    protected $table = 'impact';
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    

}
