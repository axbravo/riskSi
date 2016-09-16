<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Typedistribution extends Model
{

    protected $table = 'type_distribution';
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    

}
