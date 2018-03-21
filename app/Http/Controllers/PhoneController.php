<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\SMSRecipient;
use App\IncomingMessage; 
use App\Phone; 

class PhoneController extends Controller
{
    //
  public function checkForPhone(IncomingMessage $message){

  	$phone; 

  	if(Phone::where('number', '=', $message->incoming_number)->exists()){
       $phone = Phone::where('number', '=', $message->incoming_number)->firstOrFail();


    return $phone; 

  }
	
	
}
