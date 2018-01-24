<?php

namespace App\Http\Controllers;

use App\IncomingMessage;

use Illuminate\Http\Request;

use Twilio; 

//this was necessary along with the next one
use Notification; 

//this was necessary + use Notfication
use App\Notifications\IncomingTextMessage; 



class IncomingMessageController extends Controller
{
    

	public function create(){

	 return view('layouts.partials.form'); 

	}

	public function IncomingMessage(Request $request){


		$from = $request->input('From');
        $message = $request->input('Body');



        if (!empty($from) && !empty($message)){

            $title = 'from: '.$from;
            $msg = 'Message: '.$message;
        }

	$admin = \App\User::find(1); 
	$admin->notify(new IncomingTextMessage($from, $message)); 

	IncomingMessageController::store($from); 

	}
  

     public function store($from)

	{
		
		if (IncomingMessage::where('number', '=', $from)->exists()) {
   			echo 'Number already in DB'; 
		}

		else {


			Twilio::message($from, 'Welcom to MentorPhilly someone will be with you shortly');


			IncomingMessage::create([$from]);

		}

	}



}
