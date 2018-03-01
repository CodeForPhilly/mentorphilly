<?php

namespace App\Http\Controllers;

use App\IncomingMessage;

use Illuminate\Http\Request;

use Twilio; 

use DB; 


use App\SlackBot;

use Illuminate\Notifications\Messages\SlackMessage;

//twilio request validator
use Services_Twilio\Services_Twilio_RequestValidator;

//this is related to Notifications and was necessary to use Notfication
use Notification; 
use App\Notifications\IncomingTextMessage; 



class IncomingMessageController extends Controller
{
    

    /**
     * Create the form to handle the incoming message post
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
	public function create(){

	 return view('layouts.partials.form'); 

	}

	 /**
     * Receiving incoming twilio message and validate that it is coming from twilio 
     * before processing the message
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
	public function validateMessage(Request $request){


      $requestValidator = new \Services_Twilio_RequestValidator(env('TWILIO_TOKEN'));

      $isValid = $requestValidator->validate(
        $request->header('X-Twilio-Signature'),
        $request->fullUrl(),
        $request->toArray()
      );

      if ($isValid) {

          $this->prepareMessage($request);

		}

		else 
			echo 'You are not twilio';
	}


	/**
     * Prepare the message to send to slack
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
	public function prepareMessage($request){

		$from = '[unknown]';
      	$message = '[empty]';
      	$outgoingMedia = ''; 
      	$outgoingCity = '[unknown]';
      	$outgoingZip = '[unknown]'; 

      	if(null != $request->input('From')){
      		$from = $request->input('From');
      		$mentees = $this->checkForMentee($from);  

      		$mentee = $mentees[0]->smsname; 

      	}
      	
      	if(null != $request->input('Body'))
      		$message = $request->input('Body'); 
		
      	if(null != $request->input('MediaUrl0'))
			$outgoingMedia = $request->input('MediaUrl0');
		
		if(null != $request->input('FromCity'))
			$outgoingCity = $request->input('FromCity');
		
		if(null != $request->input('FromZip'))
			$outgoingZip = $request->input('FromZip');



		if(!empty($mentee)){      	
      		$title = 'From: '.$mentee.' @'.$from; 
      	}

      	else {

      		$title = 'From: '.$from;

      	}
        $msg = 'Message: '.$message;


        $this->sendMessage($from, $title, $message, $outgoingMedia, $outgoingCity, $outgoingZip);


	}

	public function checkForMentee($from){


			$mentee = DB::table('s_m_s_recipients')
				->join('phones','s_m_s_recipients.id','=','phones.s_m_s_recipient_id')
				->select('s_m_s_recipients.smsname')
				->where('phones.number',$from)
				->get();

				return $mentee; 


	}

	/**
     * Send the message to slack and then call the function to store it
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
	public function sendMessage($from, $title, $message, $outgoingMedia, $outgoingCity, $outgoingZip){

  //        $admin = \App\User::find(1); 

  //       //call notification
		// $admin->notify(new IncomingTextMessage($title, $message, $outgoingMedia, $outgoingCity, $outgoingZip)  ); 



         $info = '';
            $info .= '\n New Message'; 
            
            $info .= '\n '.$title;
            $pretext = $outgoingCity.', '.$outgoingZip;
            $info .= $pretext; 
            $info .= '\n\n '.$message;


    $slack_message = new SlackMessage; 

        
        $slack_message->success();
        $slack_message->content('Incoming Text Message');
        $slack_message->content($pretext);
        $slack_message->attachment(function ($attachment) {

            $attachment
                ->title($from)
                ->content($message)
                ->image($outgoingMedia);

        });

    $bot = new SlackBot; 
    $bot->chatter($slack_message, '#texts'); 
   




		//store sent message
			IncomingMessageController::store($from, $title, $message, $outgoingMedia, $outgoingCity, $outgoingZip);

	}
  

	/**
     * Store the message in the db and auto-reply if this is the first message from the 
     * number
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
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
