<?php

namespace App;


// use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use App\Notifications\IncomingTextMessage; 


class IncomingMessage extends Model
{


    
    
   

	protected $incoming_number; 
    protected $title; 
    protected $body; 
    protected $outgoingMedia;
    protected $outgoingCity; 
    protected $outgoingZip;
    protected $channel; 


  $guarded = []; 



    public function __construct()
    {
        
        $this->incoming_number = '[unknown]';

        $this->title = '[unknown]'; 

        $this->body = '[empty]';

        $this->outgoingMedia = '';

        $this->outgoingCity = '[unknown]';

        $this->outgoingZip = '[unknown]'; 

        $this->channel = '#general'; 


        // starting to build the model 
    }





   
}
