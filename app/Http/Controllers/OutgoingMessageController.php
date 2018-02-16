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

        $command = $request->input('command');
        $text = $request->input('text');
        $token = $request->input('token'); 
        $user = $request->input('user_name'); 
        $channel_id = $request->input('channel_id');
        $channel_name = $request->input('channel_name');

        $auth_token = config('services.slack.auth_token');

        if($token != $auth_token){ 
            
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

            // you have to pass an associative array of the correspnding table field when you call this
            OutgoingMessage::create(['smsname' => $user, 'channel' => $channel_name, 'number' => $to, 'message' => $message]);


            //        Schema::create('s_m_s_recipients', function (Blueprint $table) {
            // $table->increments('id');
            // $table->timestamps();
            
            // $table->string('smsname'); 
            // $table->string('channel'); 
            // $table->string('number');
        });


            }

            else {

                // Check for name corresponding name

               //  $findme   = '~';

               //  $pos = strpos($text, $findme);

               //  if ($pos !== false)
               //     $parsed = explode("~", $text);

               // else{



                
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
            'text' => 'Outgoing Text Message',
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
