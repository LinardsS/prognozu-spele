<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'App\Http\Controllers\PagesController@getHome');

Route::get('/leagues', 'App\Http\Controllers\PagesController@getLeagues');

Route::get('/contact', 'App\Http\Controllers\PagesController@getContact');

Route::get('/messages', 'App\Http\Controllers\MessagesController@getMessages');

Route::post('/contact/submit', 'App\Http\Controllers\MessagesController@submit');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::namespace('App\Http\Controllers\Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users')->group(function(){
  Route::resource('/users', 'UsersController', ['except' => ['show', 'create', 'store']]);

});

Route::namespace('App\Http\Controllers\League')->group(function(){
  Route::resource('/leagues', 'LeaguesController');
});

Route::post('/leagues/join/{league}', 'App\Http\Controllers\League\LeaguesController@join')->name('leagues.join');;
