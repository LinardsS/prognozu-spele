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
Route::post('/leagues/join/{league}', 'App\Http\Controllers\League\LeaguesController@join')->name('leagues.join');
Route::post('/leagues/leave/{league}', 'App\Http\Controllers\League\LeaguesController@leave')->name('leagues.leave');
Route::post('/leagues/submit', 'App\Http\Controllers\League\LeaguesController@submit')->name('leagues.submit');
Route::get('/leagues/joinKey', 'App\Http\Controllers\League\LeaguesController@joinKey')->name('leagues.joinKey');
Route::post('/leagues/joinByKey', 'App\Http\Controllers\League\LeaguesController@joinByKey')->name('leagues.joinByKey');
Route::get('/leagues/{league}/games', 'App\Http\Controllers\League\LeaguesController@showGames')->name('leagues.games');
Route::get('/leagues/{league}/games/add', 'App\Http\Controllers\League\LeaguesController@addGames')->name('leagues.addGames');
Route::post('/leagues/submitGame', 'App\Http\Controllers\League\LeaguesController@submitGame')->name('leagues.submitGame');

Route::namespace('App\Http\Controllers\League')->group(function(){
  Route::resource('/leagues', 'LeaguesController');
});

Route::post('/predictions/submit', 'App\Http\Controllers\PredictionsController@submit')->name('predictions.submit');
Route::get('/predictions/{league}', 'App\Http\Controllers\PredictionsController@league')->name('predictions.league');
Route::namespace('App\Http\Controllers')->group(function(){
  Route::resource('/predictions', 'PredictionsController');
});
