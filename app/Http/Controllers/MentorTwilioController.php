<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MentorTwilio; 

use Twilio; 


class MentorTwilioController extends Controller
{
    
    public function test(){




    // $fromNumber = config('twilio.twilio.connections.twilio.from');
	
    $testNumber = config('twilio.twilio.connections.twilio.test');
	$message = "Hi There from MentorPhilly"; 
    

    Twilio::message($testNumber, $message);


	echo 'Message sent';


    }

    public function message(Request $request){

     $response = $request->all();
 
    return response()->json($response);

    // $command = $request->input('command');
    // $text = $request->input('text');
    // $token = $request->input('token'); 
    // $user = $request->input('user_name'); 
    // $channel_id = $request->input('channel_id');
    // $channel_name = $request->input('channel_name');

    //     if($token != 'bd6SKRtNZ6iPqpzEVv74M4QE'){ 
    //       $sMsg = "Access Denied: the token doesn't match.";
    //       die($sMsg);
    //       return $sMsg;
    //     }


    //         else{

    //              // $testNumber = config('twilio.twilio.connections.twilio.test');
    //              // $message = $text; 
 
    //              $respond[‘text’] = $text;
    //              return $respond;
   
    //             // Twilio::message($testNumber, $message);
    //         }
        
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
