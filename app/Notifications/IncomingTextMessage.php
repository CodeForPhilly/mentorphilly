<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;



class IncomingTextMessage extends Notification
{


    protected $from; 
    protected $msg; 

    use Queueable;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($from, $msg)
    {
        //
        $this->from = $from; 

        $this->msg = $msg; 
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack($notifiable){


        return (new SlackMessage)

        ->success()
        ->content('Incoming Text Message')
        ->attachment(function ($attachment) {

            $attachment->title($this->from)->content($this->msg);

        });
    }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
