<?php


use App\Notifications\IncomingTextMessage; 
use Illuminate\Http\Request;

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


Route::get('/createrecipient', 'SMSRecipientController@create'); 

Route::post('/storerecipient','SMSRecipientController@store'); 

Route::get('/index', 'SMSRecipientController@index');


//Registration and login

Route::get('/register', 'RegistrationController@create'); 
Route::get('/login', 'SessionsController@create'); 


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

