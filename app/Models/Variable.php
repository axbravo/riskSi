<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variable extends Model
{

    protected $table = 'variable';
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    

}
