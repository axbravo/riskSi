<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Probability extends Model
{

    protected $table = 'probability';
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    

}
