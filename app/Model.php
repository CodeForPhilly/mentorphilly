<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
    //specify the fields you do not want to allow across all classes
    protected $guarded = []; 

}
