<?php


use App\Notifications\IncomingTextMessage; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {



	

    return view('welcome');


});


Route::post('/fromslack', 'MentorTwilioController@sendFromSlack');

Route::get('/test', 'MentorTwilioController@test'); 


// Route::post('/incomingMessage', 'IncomingMessageController@incomingMessage');

Route::post('/incomingMessage', function(){



		$from = $request->input('From');
        $message = $request->input('Body');

        Notification::send(new IncomingTextMessage($from, $message));

});



//this is where the form goes, the form then call the post -> store 
Route::get('/newnumber/create', 'IncomingMessageController@create');


//set up the route that will be used by the post->store 
Route::post('/newnumber','IncomingMessageController@store'); 

Route::get('/testslackformat', 'MentorTwilioController@parseSlackText'); 
