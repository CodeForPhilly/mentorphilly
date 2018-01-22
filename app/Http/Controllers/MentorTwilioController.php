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

            $arr = array(
                'title' => $title,
                "text" => $msg);
        }
   

    $returnthis = (new SlackMessage)

    ->success()
    ->attachment(function ($attachment){

    $attachment->title('Message Sent')
        -> fields([
            'To' => $to,
        ]);    
    })
    ->content($message);

    echo $returnthis; 

// return response()->json(['name' => 'Abigail', 'state' => 'CA']);

// this one work sort of 
// $jsonMessage = response()->json(['attachments' => array($arr)]);



// return response($content)
//             ->withHeaders([
//                 'Content-Type' => $type,
//                 'X-Header-One' => 'Header Value',
//                 'X-Header-Two' => 'Header Value',
//             ]);
        // header('Content-Type: application/json');
        // $jsonMessage = json_encode(array("response_type" => "in_channel", "attachments" => array($arr))); //, JSON_UNESCAPED_SLASHES
// $jsonMessage = json_encode($theMessage); //, JSON_UNESCAPED_SLASHES

// trying to just echo in channel

// $arr = array('response_type' => "in_channel");
// $jsonMessage = json_encode($arr);

    /*
Need to set the header to content-type header of the response must match the disposition of your content, application/json.
*/

// echo $jsonMessage;

   // echo "Success! Message ";
   //  echo $reply;  
   //  echo "\nTo: $to";
   //  echo "\nMessage: $msg";  

    // return (new SlackMessage)

    // ->success()
    // ->attachment(function ($attachment){

    // $attachment->title('Message Sent')
    //     -> fields([
    //         'To' => $to,
    //     ]);    
    // })
    // ->content($message);
}



public function parseSlackText ($slack_text) {






    return parsed; 



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
