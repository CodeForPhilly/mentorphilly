<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\Notifications\IncomingTextMessage; 


class IncomingMessage extends Model
{


    
    
    protected $fillable = ['number', 'title', 'message', 'outgoingMedia', 'city', 'zip'];


	protected $incoming_number; 
    protected $title; 
    protected $body; 
    protected $outgoingMedia;
    protected $outgoingCity; 
    protected $outgoingZip;
    protected $channel; 



    public function __construct()
    {
        //
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
