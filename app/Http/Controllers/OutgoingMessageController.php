<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\OutgoingMessage; 

use Twilio; 

use Illuminate\Notifications\Messages\SlackMessage;


class OutgoingMessageController extends Controller
{
   

   

public function test(){

        echo 'testing'; 
        $testNumber = config('twilio.twilio.connections.twilio.test');
        $message = "Hi There from MentorPhilly"; 
        Twilio::message($testNumber, $message);
        echo 'Message sent';
    }


      /**
     * Send Slack generated message to recipient via Twilio
     *
     * @param  Request object
     */

    public function sendFromSlack(Request $request)
    {

        $outgoingMsg = new OutgoingMessage; 

        $outgoingMsg->command = $request->input('command');
        $outgoingMsg->text = $request->input('text');
        $outgoingMsg->token = $request->input('token'); 
        $outgoingMsg->user = $request->input('user_name'); 
        $outgoingMsg->channel_id = $request->input('channel_id');
        $outgoingMsg->channel_name = $request->input('channel_name');

        $auth_token = config('services.slack.auth_token');

        if($outgoingMsg->token != $auth_token){ 
            
            $msg = "The token for the slash command doesn't match.";
            die($msg);
            echo $msg;
        }

        else {

            //look for plus

            $this->parseSlackMessage($outgoingMsg); 


           

            
        }

        if (!empty($to) && !empty($message)){

            $title = 'to: '.$to;
            $msg = 'Message: '.$message;

          // creating slack json attachments array
            $arr = array("title" => $to,
             "text" => $msg);
        }


        return response()->json([
            'response_type' => 'in_channel',
            'text' => 'Outgoing Text Message',
            'attachments' => array($arr)
        ]);        

    }


    public function parseSlackMessage(OutgoingMessage $outgoingMsg){


         

            if (!strpos($outgoingMsg->text, '+')){
                list($outgoingMsg->message, $outgoingMsg->to) = explode("+", $outgoingMsg->text);

                $outgoingMsg->to = '+'.$outgoingMsg->to; 
                Twilio::message($outgoingMsg->to, $outgoingMsg->message);

            // you have to pass an associative array of the correspnding table field when you call this
            // OutgoingMessage::create(['smsname' => $user, 'channel' => $channel_name, 'number' => $to, 'message' => $message]);
            $outgoingMsg->create(['smsname' => $outgoingMsg->user, 'channel' => $outgoingMsg->channel_name, 'number' => $outgoingMsg->to, 'message' => $outgoingMsg->message]); 

       

            }

            elseif (!strpos($outgoingMsg->text, '~')){

                 // list($outgoingMsg->message, $outgoingMsg->to) = explode("~", $outgoingMsg->text);

                // Check for name corresponding name

               //  $findme   = '~';

               //  $pos = strpos($text, $findme);

               //  if ($pos !== false)
               //     $parsed = explode("~", $text);

               // else{



                
            }



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
