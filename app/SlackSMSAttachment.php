<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SlackSMSAttachment extends Model
{
    //

    protected $body; 
    protected $title; 
    protected $location; 
    protected $media; 

    public function __construct($body, $title, $location, $media){


        $this->body = $body; 
        $this->title = $title; 
        $this->location = $location; 
        $this->media = media;
    }

    public function getAttachments(){

     $attachment = '[
      {
        "fallback": "'.$this->body.'",
        "color": "#36a64f",

        "author_name": "Message Details",

        "title": "'.$this->title.'",


        "fields": [
          {
            "title": "Location",
            "value": "'.$this->location.'",
            "short": false
          }
        ],

        "text": "'.$this->body.'",     
        "thumb_url": "'.$this->media.'",
        "footer": "MentorPhilly Text Service"
      }
    ]';

    return $attachment; 

    }
}
