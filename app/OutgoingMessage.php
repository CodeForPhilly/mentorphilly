<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OutgoingMessage extends Model
{
    //
     	protected $fillable = ['smsname','channel','number','message'];

     	protected $command;
        protected $text;
        protected $token; 
        protected $user; 
        protected $channel_id;
        protected $channel_name;
        protected $to; 
        protected $message; 

        protected $title;
}
