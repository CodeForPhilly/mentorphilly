<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Twilio; 

use Notification; 

use App\Notifications\IncomingTextMessage; 



class IncomingMessageController extends Controller
{
    

	public function create(){

	 return view('layouts.partials.form'); 

	}

	public function IncomingMessage(Request $request){


		$from = $request->input('From');
        $message = $request->input('Body');



        if (!empty($from) && !empty($message)){

            $title = 'from: '.$from;
            $msg = 'Message: '.$message;
        }

	$admin = \App\User::find(1); 
	$admin->notify(new IncomingTextMessage($from, $message)); 

	}
  

     public function store()

	{

		$this->validate(request(), [

			'number' => 'required|max:12|min:12'

		]);
		

		$new_no = request(['number']); 
		if (IncomingMessage::where('number', '=', $new_no)->exists()) {
   			echo 'Number already in DB'; 
		}

		else {

			echo 'Number does not exist saving to DB'; 
			IncomingMessage::create($new_no);

		}

	}



}
