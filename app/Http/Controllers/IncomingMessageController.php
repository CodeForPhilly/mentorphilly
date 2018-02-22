<?php

namespace App\Http\Controllers;

use App\IncomingMessage;

use Illuminate\Http\Request;

use Twilio; 

//twilio request validator
use Services_Twilio\Services_Twilio_RequestValidator;

//this is related to Notifications and was necessary to use Notfication
use Notification; 
use App\Notifications\IncomingTextMessage; 


class IncomingMessageController extends Controller
{
    

	public function create(){

	 return view('layouts.partials.form'); 

	}

	public function validate(Request $request){


      $requestValidator = new \Services_Twilio_RequestValidator(env('TWILIO_TOKEN'));

      $isValid = $requestValidator->validate(
        $request->header('X-Twilio-Signature'),
        $request->fullUrl(),
        $request->toArray()
      );

      if ($isValid) {

      	
          prepareMessage($request);

           


		}

		else 
			echo 'You are not twilio';
	}


	public function prepareMessage($request){

		$from = '[unknown]';
      	$message = '[empty]';
      	$outgoingMedia = ''; 
      	$outgoingCity = '[unknown]';
      	$outgoingZip = '[unknown]'; 

      	if(null != $request->input('From'))
      		$from = $request->input('From'); 
      	
      	if(null != $request->input('Body'))
      		$message = $request->input('Body'); 
		
      	if(null != $request->input('MediaUrl0'))
			$outgoingMedia = $request->input('MediaUrl0');
		
		if(null != $request->input('FromCity'))
			$outgoingCity = $request->input('FromCity');
		
		if(null != $request->input('FromZip'))
			$outgoingZip = $request->input('FromZip');
      	
      	$title = 'From: '.$from;
        $msg = 'Message: '.$message;



         $admin = \App\User::find(1); 
			$admin->notify(new IncomingTextMessage($title, $message, $outgoingMedia, $outgoingCity, $outgoingZip)); 
			IncomingMessageController::store($from, $title, $message, $outgoingMedia, $outgoingCity, $outgoingZip);


	}
  

     public function store($from, $title, $message, $outgoingMedia, $outgoingCity, $outgoingZip)

	{
		
		if (IncomingMessage::where('number', '=', $from)->exists()) {
   			echo 'Number already in DB'; 
   			$storefrom = (string)$from; 
   			IncomingMessage::create(['number' => $storefrom, 'title' => $title, 'message' => $message, 'outgoingMedia' => $outgoingMedia, 'city' => $outgoingCity, 'zip' => $outgoingZip ]);
		}

		else {


			Twilio::message($from, 'Welcome to MentorPhilly! Someone will respond to you within 24 hours.');

			$storefrom = (string)$from; 

			// you have to pass an associative array of the correspnding table field when you call this
			IncomingMessage::create(['number' => $storefrom, 'title' => $title, 'message' => $message, 'outgoingMedia' => $outgoingMedia, 'city' => $outgoingCity, 'zip' => $outgoingZip ]);

		}

	}



}
