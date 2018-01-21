<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Twilio; 

class MentorTwilioController extends Controller
{
    
    public function test(){

    	// $fromNumber = config('twilio.twilio.connections.twilio.from');
	$testNumber = config('twilio.twilio.connections.twilio.test');
	$message = "Hi There from MentorPhilly"; 
    Twilio::message($testNumber, $message);

 //    $accountId = config('twilio.twilio.connections.twilio.sid');
	// $token = config('twilio.twilio.connections.twilio.token');
	// $fromNumber = config('twilio.twilio.connections.twilio.from');
	// $testNumber = config('twilio.twilio.connections.twilio.test');

	// $twilio = new Aloha\Twilio\Twilio($accountId, $token, $fromNumber);

	// $twilio->message($testNumber, 'Pink Elephants and Happy Rainbows');

	echo 'Message sent';


    }


    		//Creates a new post and requests the array passed in and saves it to the db
		//IMPORTANT: BE EXPLICIT! only pass the fields you are comfortable submitted to the server
		MentorTwilio::create(request(['title','body']));
		/*

		^^^ that does the same as this:
		$post = new Post; 
		//Create a new post using the request data
		$post->title = request('title'); 
		$post->body = request('body'); 
		$post->save(); 
		// Save it to the database */

		// And then redirect to the homepage
		return redirect('/');

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
