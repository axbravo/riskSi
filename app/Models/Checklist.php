<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class checklist extends Model
{

    protected $table = 'checklist';
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    

}
