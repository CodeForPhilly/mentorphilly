<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MentorTwilio; 

use Twilio; 

use Illuminate\Notifications\Messages\SlackMessage;


class MentorTwilioController extends Controller
{

    public function test(){

        echo 'testing'; 


    // $fromNumber = config('twilio.twilio.connections.twilio.from');

        $testNumber = config('twilio.twilio.connections.twilio.test');
        $message = "Hi There from MentorPhilly"; 


        Twilio::message($testNumber, $message);


        echo 'Message sent';


    }

    public function order(Request $request)
    {

        $command = $request->input('command');
        $text = $request->input('text');
        $token = $request->input('token'); 
        $user = $request->input('user_name'); 
        $channel_id = $request->input('channel_id');
        $channel_name = $request->input('channel_name');


        $auth_token = config('services.slack.auth_token');


        if($token != $auth_token){ 

          # replace this with the token from your slash command
            $msg = "The token for the slash command doesn't match.";
            die($msg);
            echo $msg;
        }

        else {


            $findme   = '+';

            $pos = strpos($text, $findme);

            if ($pos !== false){
                list($message, $to) = explode("+", $text);

                $to = '+'.$to; 
                Twilio::message($to, $message);

               
            }

            else {

               //  $findme   = '~';

               //  $pos = strpos($text, $findme);

               //  if ($pos !== false)
               //     $parsed = explode("~", $text);

               // else{

                MentorTwilio::test(); 
            }

            
        }

        if (!empty($to) && !empty($message)){

            $title = 'to: '.$to;
            $msg = 'Message: '.$message;

          // creating slack json attachments array
  $arr = array("title" => $to,
   "text" => $msg);
        }


return response()->json([
    'text' => $to,
    'attachments' => array($arr)
]);        
   
}



public function parseSlackText () {

$to = 'to: somenumber'; 
$message = 'somemessage'; 
$title = 'sometitle'; 


// creating slack json attachments array
  $arr = array("title" => $to,
   "text" => $message);

// set json header for Slack 
// header('Content-Type: application/json');

// convert theMessage to json so Slack can read it
// $jsonMessage = json_encode(array("text" => $whichMeetup, "attachments" => array($arr))); 





return response()->json([
    'text' => $to,
    'attachments' => array($arr)
]);




}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
