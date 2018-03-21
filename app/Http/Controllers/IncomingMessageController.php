<?php

namespace App\Http\Controllers;

use App\IncomingMessage;
use App\Phone;
use App\SMSRecipient; 

use Illuminate\Http\Request;

use Twilio; 

use DB; 

//for sending with Slackbot
use App\SlackBot;

//twilio request validator
use Services_Twilio\Services_Twilio_RequestValidator;

//this is related to Notifications and was necessary to use Notfication
use Notification; 
use App\Notifications\IncomingTextMessage; 


class IncomingMessageController extends Controller
{
  public function __construct()
  {

    $this->middleware('twiliovalidate', ['only'=> 'prepareMessage']); 


  }

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



	/**
     * Prepare the message to send to slack
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
	public function prepareMessage(Request $request){


    $message = new IncomingMessage(); 


      	// if(null != $request->input('From')){
      	// 	$incoming_number = $request->input('From');
      	// 	$mentees = $this->checkForMentee($incoming_number);  
       //    if(!empty($mentees))
      	// 	  $mentee = $mentees[0]->smsname;
      	// }

        // if(!empty($mentees[0]->channel)){

            // $channel = $mentees[0]->channel;
          // } 
          // else 

    $message->incoming_number = '[unknown]';

    $message->title = '[unknown]'; 

    $message->body = '[empty]';

    $message->outgoingMedia = '';

    $message->outgoingCity = '[unknown]';

    $message->outgoingZip = '[unknown]'; 

    $message->channel = '#general'; 

    
    
    if(null != $request->input('Body'))
      $message->body = 'Message: '.$request->input('Body'); 
    
    if(null != $request->input('MediaUrl0'))
     $message->outgoingMedia = $request->input('MediaUrl0');
   
   if(null != $request->input('FromCity'))
     $message->outgoingCity = $request->input('FromCity');
   
   if(null != $request->input('FromZip'))
     $message->outgoingZip = $request->input('FromZip');


   if(null != $request->input('From')){
     $message->incoming_number = $request->input('From');
     $title = 'From: '.$message->incoming_number;
     $message->title = $title; 
   }
   


    //send auto reply if the number hasn't text us before 
   if(!IncomingMessage::where('number', '=', $message->incoming_number)->exists())
    Twilio::message($message->incoming_number, 'Welcome to MentorPhilly! Someone will respond to you within 24 hours.');

    
    $phone = new Phone(); 

    $phone = $this->checkForPhone($message, $phone);

    //check if mentee is in list of sms recipients
    if($phone != null)
      $this->updateIncomingMessage($message, $phone); 
    
    

    $this->sendMessageToSlack($message);
    $this->store($message); 



  }


   //
  public function checkForPhone(IncomingMessage $message, Phone $phone){

    // if(Phone::where('number', '=', $message->incoming_number)->exists()){

    //   $phone = Phone::where('number', '=', $message->incoming_number)->first();
    //   return $phone; 
    // }
    // else
    //   return null; 

     return $phone->where('number', '=', $message->incoming_number)->first();
}
    

  }


  public function updateIncomingMessage(IncomingMessage $message, Phone $phone){

    $sms_recipient = new SMSRecipient(); 

    $message->title = 'Phone: ' . $phone->number;

       //if the phone number exists in the db, look up the corresponding recipient and store it 
       // in sms_recipient
    if(SMSRecipient::where('id','=',$phone->s_m_s_recipient_id)->exists()){
      $sms_recipient = SMSRecipient::where('id','=',$phone->s_m_s_recipient_id)->first();
            // update the title 
      $message->title = 'From: ' . $sms_recipient->smsname . $phone->number; 
    }


  }

// public function checkForMentee($incoming_number){


//  $mentee = DB::table('s_m_s_recipients')
//  ->join('phones','s_m_s_recipients.id','=','phones.s_m_s_recipient_id')
//  ->select('s_m_s_recipients.smsname')
//  ->where('phones.number',$incoming_number)
//  ->get();

//  return $mentee; 


// }

	/**
     * Send the message to slack and then call the function to store it
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
	public function sendMessageToSlack(IncomingMessage $message){


  //log all texts to webhook slack channel
    $admin = \App\User::find(1); 
  //call notification
    $admin->notify(new IncomingTextMessage($message->title, $message->body, $message->outgoingMedia, $message->outgoingCity, $message->outgoingZip)  ); 
    
  // // prepare attachment for Slack
  // $location = $outgoingCity.', '.$outgoingZip;
    
  // //json formatted attachment  
  // $attachment = '[
  //       {
  //           "fallback": "'.$message.'",
  //           "color": "#36a64f",
    
  //           "author_name": "Message Details",
    
  //           "title": "'.$title.'",
    
    
  //           "fields": [
  //               {
  //                   "title": "Location",
  //                   "value": "'.$location.'",
  //                   "short": false
  //               }
  //           ],
    
  //           "text": "'.$message.'",     
  //           "thumb_url": "'.$outgoingMedia.'",
  //           "footer": "MentorPhilly Text Service"
  //       }
  //   ]';

  //   //create new slackbot class to send using slackbot
  //   $bot = new SlackBot; 
  //   $bot->chatter($attachment, $channel); 
    
		//store sent message

  }
  
	/**
     * Store the message in the db and auto-reply if this is the first message from the 
     * number
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
 public function store(IncomingMessage $message)

 {

  IncomingMessage::create(
    [
      'number' => $message->incoming_number, 
      'title' => $message->title, 
      'message' => $message->body, 
      'outgoingMedia' => $message->outgoingMedia, 
      'city' => $message->outgoingCity, 
      'zip' => $message->outgoingZip 
    ]
  );

}


}
