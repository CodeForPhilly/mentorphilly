<?php

namespace App\Http\Controllers;

use App\IncomingMessage;
use App\Phone;
use App\SMSRecipient; 

use Illuminate\Http\Request;

use Twilio; 

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
     * Prepare the message to send to slack
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
	public function prepareMessage(Request $request){


    $message = new IncomingMessage(); 

    $message->incoming_number = '[unknown]';

    $message->title = '[unknown]'; 

    $message->body = '[empty]';

    $message->outgoingMedia = '';

    $message->outgoingCity = '[unknown]';

    $message->outgoingZip = '[unknown]'; 


    $message->channel = '#texts'; 

    $message->channel = config('services.slack.default-channel'); 


    
    
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
   



   $this->autoResponse($message); 
    
    $phone = new Phone(); 

   //  //check if we already have this number in the db
    $phone = $this->checkForPhone($message, $phone);

   //  //if we have that phone (!null) then update the message with the corresponding name
    if($phone != null)
      $this->updateIncomingMessage($message, $phone); 
    
    $this->sendMessageToSlack($message);
    $this->store($message); 



  }


  public function autoResponse(IncomingMessage $message){


    try {

      $recordBoolean = IncomingMessage::where('number', '=', $message->incoming_number)->count() > 0; 

      if($recordBoolean == false)
        Twilio::message($message->incoming_number, 'Welcome to MentorPhilly! Someone will respond to you within 24 hours.');
      }
      catch (\Exception $e) {

        $error =  $e->getMessage();

        $message->body = "Error:\n" . $error. "\n\n" . $message->body; 

        $admin->notify(new IncomingTextMessage("'Error: ' . $message->title", $message->body, $message->outgoingMedia, $message->outgoingCity, $message->outgoingZip)  );
        
      }



    }

   //
    public function checkForPhone(IncomingMessage $message, Phone $phone){

      try {

        return $phone->where('number', '=', $message->incoming_number)->first();

      }

      catch (\Exception $e) {

        $error =  $e->getMessage();

        $message->body = "Error:\n" . $error. "\n\n" . $message->body; 

        $admin->notify(new IncomingTextMessage("'Error: ' . $message->title", $message->body, $message->outgoingMedia, $message->outgoingCity, $message->outgoingZip)  );


      }


    }


    public function updateIncomingMessage(IncomingMessage $message, Phone $phone){

      $sms_recipient = new SMSRecipient(); 

      $message->title = 'Phone: ' . $phone->number;

      //if the phone number exists in the db, look up the corresponding recipient and store it in sms_recipient

      try{
        if(SMSRecipient::where('id','=',$phone->s_m_s_recipient_id)->exists()){
          $sms_recipient = SMSRecipient::where('id','=',$phone->s_m_s_recipient_id)->first();
          
           // update the title to reflect the name of the recipient
          $message->title = 'From: ' . $sms_recipient->smsname . " " . $phone->number;
          $message->channel = $sms_recipient->channel;  
        }
      }

      catch (\Exception $e) {

        $error =  $e->getMessage();

        $message->body = "Error:\n" . $error. "\n\n" . $message->body; 

        $admin->notify(new IncomingTextMessage("'Error: ' . $message->title", $message->body, $message->outgoingMedia, $message->outgoingCity, $message->outgoingZip)  );


      }


    }

	/**
     * Send the message to slack and then call the function to store it
     *
     * @param  \Illuminate\Http\Request  $request
     *
     */
	public function sendMessageToSlack(IncomingMessage $message){

  // prepare attachment for Slack
    $location = $message->outgoingCity.', '.$message->outgoingZip;
    $channel = $message->channel;

  //json formatted attachment  
    $attachment = '[
      {
        "fallback": "'.$message->body.'",
        "color": "#36a64f",

        "author_name": "Message Details",

        "title": "'.$message->title.'",


        "fields": [
          {
            "title": "Location",
            "value": "'.$location.'",
            "short": false
          }
        ],

        "text": "'.$message->body.'",     
        "thumb_url": "'.$message->outgoingMedia.'",
        "footer": "MentorPhilly Text Service"
      }
    ]';

    //create new slackbot class to send using slackbot
    $bot = new SlackBot; 
    $bot->chatter($attachment, $channel); 
    
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
