<?php

namespace App\Http\Middleware;

// use Illuminate\Foundation\Http\Middleware\TwilioRequestValidator as Middleware;


use Closure;

//twilio request validator
use Services_Twilio\Services_Twilio_RequestValidator;
use Illuminate\Http\Response;

class TwilioRequestValidator 
{
      
     protected $except = [
        'fromslack',
        'incomingMessageTest', 
        'incomingMessage'
      ]; 
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
         // Be sure TWILIO_APP_TOKEN is set in your .env file.
      // You can get your app token in your twilio console https://www.twilio.com/console
      


      $requestValidator = new \Services_Twilio_RequestValidator(env('TWILIO_TOKEN'));

      $isValid = $requestValidator->validate(
        $request->header('X-Twilio-Signature'),
        $request->fullUrl(),
        $request->toArray()
      );

      

           try {
        // Validate the value...
             if ($isValid) {
        return $next($request);
      }
    } catch (Exception $e) {
        report($e);

        return false;
    }

      
    }
}
