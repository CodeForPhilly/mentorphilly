<?php

namespace App\Http\Controllers;

use App\IncomingMessage;

use Illuminate\Http\Request;

use Twilio; 

//twilio request validator
use Services_Twilio\Services_Twilio_RequestValidator;

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


		

      $requestValidator = new \Services_Twilio_RequestValidator(env('TWILIO_TOKEN'));

      $isValid = $requestValidator->validate(
        $request->header('X-Twilio-Signature'),
        $request->fullUrl(),
        $request->toArray()
      );

      if ($isValid) {

      	$from = '[unknown]';
      	$message = '[empty]';
      	$outgoingMedia = ''; 
      	$outgoingCity = '[unknown]';
      	$outgoingZip = '[unknown]'; 

      	if(isset($request->input('From')))
      		$from = $request->input('From'); 
      	
      	if(isset($request->input('Body')))
      		$message = $request->input('Body'); 
		
      	if(isset($request->input('MediaUrl0')))
			$outgoingMedia = $request->input('MediaUrl0');
		
		if(isset($request->input('FromCity')))
			$outgoingCity = $request->input('FromCity');
		
		if(isset($request->input('FromZip')))
			$outgoingZip = $request->input('FromZip');
      	
      	$title = 'From: '.$from;
        $msg = 'Message: '.$message;
          

            $admin = \App\User::find(1); 
			$admin->notify(new IncomingTextMessage($title, $message, $outgoingMedia, $outgoingCity, $outgoingZip)); 
			IncomingMessageController::store($from);


		}

		else 
			echo 'You are not twilio';
	}
  

     public function store($from)

	{
		
		if (IncomingMessage::where('number', '=', $from)->exists()) {
   			echo 'Number already in DB'; 
		}

		else {


			Twilio::message($from, 'Welcome to MentorPhilly someone will be with you shortly');

			$storefrom = (string)$from; 

			// you have to pass an associative array of the correspnding table field when you call this
			IncomingMessage::create(['number' => $storefrom]);

		}

	}



}
