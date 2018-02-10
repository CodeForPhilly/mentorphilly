<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class WelcomeRegisteredUser extends Mailable
{
    use Queueable, SerializesModels;

    public $welcome_data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($welcome_data)
    {
        //
        $this->welcome_data = $welcome_data; 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.welcome');
    }
}
