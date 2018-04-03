<?php

namespace App;


// use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use App\Notifications\IncomingTextMessage;

use Illuminate\Database\Eloquent\Model;


class IncomingMessage extends Model
{


    
    
   

	protected $incoming_number; 
    protected $title; 
    protected $body; 
    protected $outgoingMedia;
    protected $outgoingCity; 
    protected $outgoingZip;
    protected $channel; 


    protected $guarded = []; 


   
}
