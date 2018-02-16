<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OutgoingMessage extends Model
{
    //
     protected $fillable = ['smsname','channel','number','message'];
}
