<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\IncomingMessage; 
use App\Notifications\IncomingTextMessage; 

use Twilio; 



class IncomingMessageController extends Controller
{
    

	public function create(){

	 return view('layouts.partials.form'); 

	}


	public function incomingMessage(Request $request){


		$from = $request->input('From');
        $message = $request->input('Body');



        if (!empty($from) && !empty($message)){

            $title = 'from: '.$from;
            $msg = 'Message: '.$message;
        }


      Notification::send(new IncomingTextMessage($from, $message));


	}


	public function incomingMessageTest(){


		$from = 'from corey';
        $message = 'the message';



        if (!empty($from) && !empty($message)){

            $title = 'from: '.$from;
            $msg = 'Message: '.$message;

        }

	Notification::send(new IncomingTextMessage($from, $message));


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
