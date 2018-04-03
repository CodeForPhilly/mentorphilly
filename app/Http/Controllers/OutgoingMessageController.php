<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\OutgoingMessage; 

use Twilio; 

use Illuminate\Notifications\Messages\SlackMessage;

use App\Phone;
use App\SMSRecipient; 


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

            $outgoingMsg = $this->parseSlackMessage($outgoingMsg); 


           

            
        }

        $arr = []; 

        if (!empty($outgoingMsg->to) && !empty($outgoingMsg->message)){

            $outgoingMsg->title = 'to: '.$outgoingMsg->to;
            $outgoingMsg->message = 'Message: '.$outgoingMsg->message;

          // creating slack json attachments array
            $arr = array("title" => $outgoingMsg->to,
             "text" => $outgoingMsg->message);
        }


        return response()->json([
            'response_type' => 'in_channel',
            'text' => 'Outgoing Text Message',
            'attachments' => array($arr)
        ]);        

    }


    public function parseSlackMessage(OutgoingMessage $outgoingMsg){


         

            if (strpos($outgoingMsg->text, '+')){
                list($outgoingMsg->message, $outgoingMsg->to) = explode("+", $outgoingMsg->text);

                $outgoingMsg->to = '+'.$outgoingMsg->to; 
                Twilio::message($outgoingMsg->to, $outgoingMsg->message);

            // you have to pass an associative array of the correspnding table field when you call this
            // OutgoingMessage::create(['smsname' => $user, 'channel' => $channel_name, 'number' => $to, 'message' => $message]);
            $outgoingMsg->create(['smsname' => $outgoingMsg->user, 'channel' => $outgoingMsg->channel_name, 'number' => $outgoingMsg->to, 'message' => $outgoingMsg->message]); 

       

            }

            elseif (strpos($outgoingMsg->text, '~')){

                list($outgoingMsg->message, $outgoingMsg->to) = explode("~", $outgoingMsg->text);

                // Check for name corresponding name

                $name = $outgoingMsg->to; 


               $person = new SMSRecipient(); 
               $phone = new Phone(); 

               //find the person with a channel name equivalent to what's typed after the tilda
               $person = SMSRecipient::where('smsname', 'LIKE', $name)->first();



              if($person != null){
                $personid = $person->id; 

               $phone = Phone::where('s_m_s_recipient_id', '=', $personid)->first();

               if($phone != null)
                $outgoingMsg->to = $phone->number; 

                else 
                    $outgoingMsg->to = '+12155158774'; 
            
                 
                Twilio::message($outgoingMsg->to, $outgoingMsg->message);

                $outgoingMsg->create(['smsname' => $outgoingMsg->user, 'channel' => $outgoingMsg->channel_name, 'number' => $outgoingMsg->to, 'message' => $outgoingMsg->message]); 

            }

            } 

        return $outgoingMsg; 

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
