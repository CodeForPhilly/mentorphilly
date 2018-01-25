<?php

namespace App\Http\Controllers;

use App\IncomingMessage;

use Illuminate\Http\Request;

use Twilio; 

//this was necessary along with the next one
use Notification; 

//this was necessary + use Notfication
use App\Notifications\IncomingTextMessage; 


//twilio request validator
use Twilio;


class CoreyValidate
{

    protected $AuthToken;

    function __construct($token)
    {
        $this->AuthToken = $token;
    }
    
    public function computeSignature($url, $data = array())
    {
        // sort the array by keys
        ksort($data);

        // append them to the data string in order
        // with no delimiters
        foreach($data as $key => $value)
            $url .= "$key$value";
            
        // This function calculates the HMAC hash of the data with the key
        // passed in
        // Note: hash_hmac requires PHP 5 >= 5.1.2 or PECL hash:1.1-1.5
        // Or http://pear.php.net/package/Crypt_HMAC/
        return base64_encode(hash_hmac("sha1", $url, $this->AuthToken, true));
    }

    public function validate($expectedSignature, $url, $data = array())
    {
        return self::compare(
            $this->computeSignature($url, $data),
            $expectedSignature
        );
    }

    /**
     * Time insensitive compare, function's runtime is governed by the length
     * of the first argument, not the difference between the arguments.
     * @param $a string First part of the comparison pair
     * @param $b string Second part of the comparison pair
     * @return bool True if $a == $b, false otherwise.
     */
    public static function compare($a, $b) {
        $result = true;

        if (strlen($a) != strlen($b)) {
            return false;
        }

        if (!$a && !$b) {
            return true;
        }

        $limit = strlen($a);

        for ($i = 0; $i < $limit; ++$i) {
            if ($a[$i] != $b[$i]) {
                $result = false;
            }
        }

        return $result;
    }

}


class IncomingMessageController extends Controller
{
    

	public function create(){

	 return view('layouts.partials.form'); 

	}

	public function IncomingMessage(Request $request){


		

      $requestValidator = new CoreyValidate(env('TWILIO_TOKEN'));

      $isValid = $requestValidator->validate(
        $request->header('X-Twilio-Signature'),
        $request->fullUrl(),
        $request->toArray()
      );

      if ($isValid) {

      	  if (!empty($from) && !empty($message)){

            $title = 'from: '.$from;
            $msg = 'Message: '.$message;
        }

		$admin = \App\User::find(1); 
		$admin->notify(new IncomingTextMessage($from, $message)); 

		IncomingMessageController::store($from);

		}

		else 
			return new Response('You are not Twilio :(', 403);
	}
  

     public function store($from)

	{
		
		if (IncomingMessage::where('number', '=', $from)->exists()) {
   			echo 'Number already in DB'; 
		}

		else {


			Twilio::message($from, 'Welcome to MentorPhilly someone will be with you shortly');

			$storefrom = (string)$from; 

			// you have to pass an associative array of the correspnding table field when you call this
			IncomingMessage::create(['number' => $storefrom]);

		}

	}



}
