<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMSRecipient extends Model
{
 
  protected $fillable = ['smsname', 'number','channel'];
 //    public function user()
	// {
	// 	return $this->belongsTo(User::class); 

	// }
}
