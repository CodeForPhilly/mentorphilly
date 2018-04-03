<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    
        //

         protected $except = [
        '/fromslack',
        '/incomingMessageTest', 
        '/incomingMessage', 
        'https://staging.modelb.tech/incomingMessage', 
        'https://modelb.tech/incomingMessage'
    
    ];
}
