<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\IncomingMessage; 

class IncomingMessageController extends Controller
{
    

	public function create(){

		 return view('layouts.partials.form'); 

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
