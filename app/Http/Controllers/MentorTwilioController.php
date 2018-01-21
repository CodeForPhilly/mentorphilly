<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MentorTwilio; 

use Twilio; 


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

 
         if($token != 'bd6SKRtNZ6iPqpzEVv74M4QE'){ 
           
          # replace this with the token from your slash command
                        $msg = "The token for the slash command doesn't match.";
                        die($msg);
                          echo $msg;
         }

    else {
  // check for + or ~ 


  //find the number in the message from slack string
  $findme   = '+';

  $pos = strpos($body, $findme);

  if ($pos !== false) {

    // perform message assembly for +

  //convert post string for body from slack to an array
    $explodedBody = str_split($body);

  //count the length of the body array
    $arrayLength = count($explodedBody);

  //create variable for the message array
    $msgArray = array();



//iterate through the body array until you reach the '+' symbol 
//push each character on to the message array  
    for ($i = 0; $i < $pos; $i++) {
      array_push($msgArray, $explodedBody[$i]);
    }
    $msg = implode($msgArray);


// create array to hold the phone number
    $toArray = array();


    for ($j = $pos; $j < $arrayLength; $j++) {
      array_push($toArray, $explodedBody[$j]);

    }
    $to = implode($toArray);



  }

  else { 

    $findme   = '~';

    $pos = strpos($body, $findme);

    if ($pos !== false) {



  //convert post string for body from slack to an array
      $explodedBody = str_split($body);

  //count the length of the body array
      $arrayLength = count($explodedBody);

  //create variable for the message array
      $msgArray = array();



//iterate through the body array until you reach the '~' symbol 
//push each character on to the message array  
      for ($i = 0; $i < $pos; $i++) {
        array_push($msgArray, $explodedBody[$i]);
      }
      $msg = implode($msgArray);


// create array to hold the phone number
      $toArray = array();

      // move the position pointer up oone to skip ~
       $pos = $pos + 1; 


      for ($j = $pos; $j < $arrayLength; $j++) {
        array_push($toArray, $explodedBody[$j]);

      }
      $toName = implode($toArray);
       $to = '+19178305148';


// search the database for matching name
      foreach ($people as $key => $value){

        if(strcasecmp($value, $toName) == 0) {
          $to = $key;
        }

      }


    }

    else {

      $to = '+19178305148';
      $msg = " ~ Character not found";
  } // close else statement checking for ~



} // close checking for + else
  


    }



             $respond['text'] = $text;
            return $respond;
 
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
