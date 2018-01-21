<?php

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


Route::post('/fromslack', 'MentorTwilioController@test');

Route::get('/test', 'MentorTwilioController@test'); 


//this is where the form goes, the form then call the post -> store 
// Route::get('/newnumber/create', 'IncomingMessageController@create');


//set up the route that will be used by the post->store 
// Route::post('/newnumber','IncomingMessageController@store'); 
