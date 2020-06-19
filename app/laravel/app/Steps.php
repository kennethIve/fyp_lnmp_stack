<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Steps extends Model
{
    //
    protected $table = "steps";

    protected $primaryKey = "steps_id";    
    public $timestamps = false;
}
