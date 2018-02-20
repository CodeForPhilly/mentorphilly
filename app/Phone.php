<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{

	protected $fillable = ['number'];

    public function s_m_s_recipient()
	{
		return $this->belongsTo('App\SMSRecipient'); 

		  // return $this->belongsTo('App\User', 'foreign_key');

	}


}
