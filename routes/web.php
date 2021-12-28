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
//Home
Route::get('/', 'App\Http\Controllers\PagesController@getHome');
//Saziņa
Route::get('/contact', 'App\Http\Controllers\MessagesController@getContact');
Route::get('/messages', 'App\Http\Controllers\MessagesController@getMessages')->name('messages');
Route::post('/messages/read/{message}', 'App\Http\Controllers\MessagesController@markAsRead')->name('messages.read');
Route::post('/messages/unread/{message}', 'App\Http\Controllers\MessagesController@markAsUnread')->name('messages.unread');
Route::post('/contact/submit', 'App\Http\Controllers\MessagesController@submit');
//Auth
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Admin
Route::namespace('App\Http\Controllers\Admin')->prefix('admin')->name('admin.')->middleware('can:manage-users')->group(function(){
  Route::resource('/users', 'UsersController', ['except' => ['show', 'create', 'store']]);

});
//League
Route::post('/leagues/join/{league}', 'App\Http\Controllers\League\LeaguesController@join')->name('leagues.join');
Route::post('/leagues/leave/{league}', 'App\Http\Controllers\League\LeaguesController@leave')->name('leagues.leave');
Route::post('/leagues/submit', 'App\Http\Controllers\League\LeaguesController@submit')->name('leagues.submit');
Route::get('/leagues/joinKey', 'App\Http\Controllers\League\LeaguesController@joinKey')->name('leagues.joinKey');
Route::post('/leagues/joinByKey', 'App\Http\Controllers\League\LeaguesController@joinByKey')->name('leagues.joinByKey');
Route::get('/leagues/{league}/games', 'App\Http\Controllers\League\LeaguesController@showGames')->name('leagues.games');
Route::get('/leagues/{league}/games/results', 'App\Http\Controllers\League\LeaguesController@showGamesResults')->name('leagues.results');
Route::get('/leagues/{league}/games/add', 'App\Http\Controllers\League\LeaguesController@addGames')->name('leagues.addGames');
Route::post('/leagues/submitGame', 'App\Http\Controllers\League\LeaguesController@submitGame')->name('leagues.submitGame');
Route::post('/leagues/{league}/delete/{user}', 'App\Http\Controllers\League\LeaguesController@deleteUser')->name('leagues.deleteUser');
Route::get('/leagues/{league}/edit', 'App\Http\Controllers\League\LeaguesController@edit')->name('leagues.edit')->middleware('edit.league');
Route::get('/leagues/{league}/detach/{game}', 'App\Http\Controllers\League\LeaguesController@detachGame')->name('leagues.detachGame')->middleware('edit.league');


Route::namespace('App\Http\Controllers\League')->group(function(){
  Route::resource('/leagues', 'LeaguesController', ['except' => ['edit']]);
});
//Predictions
Route::post('/predictions/submit', 'App\Http\Controllers\PredictionsController@submit')->name('predictions.submit');
Route::get('/predictions/{league}', 'App\Http\Controllers\PredictionsController@league')->name('predictions.league')->middleware('view.predictions');
Route::namespace('App\Http\Controllers')->group(function(){
  Route::resource('/predictions', 'PredictionsController');
});
//Results
Route::get('/results/PL', 'App\Http\Controllers\ResultsController@getPLResults')->name('results.PL')->middleware('upload.games');
Route::get('/results/NHL', 'App\Http\Controllers\ResultsController@getNHLResults')->name('results.NHL')->middleware('upload.games');
Route::get('/results/NBA', 'App\Http\Controllers\ResultsController@getNBAResults')->name('results.NBA')->middleware('upload.games');
Route::post('/results/add', 'App\Http\Controllers\ResultsController@submit')->name('results.submit');
Route::get('/results/add/{league}/{game}', 'App\Http\Controllers\ResultsController@add')->name('results.add');
Route::get('/results/{user}/{league}', 'App\Http\Controllers\ResultsController@league')->name('results.league');
Route::namespace('App\Http\Controllers')->group(function(){
  Route::resource('/results', 'ResultsController');
});
//Games
Route::get('/games/uploadNHL/{startDate}/{endDate}', 'App\Http\Controllers\GamesController@uploadNHLGames')->name('games.uploadNHLGames')->middleware('upload.games');
Route::get('/games/attach/NHL/{league}', 'App\Http\Controllers\GamesController@attachNHLGames')->name('games.attachNHL')->middleware('upload.games');
Route::get('/games/uploadNBA/{startDate}/{endDate}', 'App\Http\Controllers\GamesController@uploadNBAGames')->name('games.uploadNBAGames')->middleware('upload.games');
Route::get('/games/testNBA/{startDate}/{endDate}', 'App\Http\Controllers\GamesController@testNBATime')->name('games.testNBATime')->middleware('upload.games');
Route::get('/games/attach/NBA/{league}', 'App\Http\Controllers\GamesController@attachNBAGames')->name('games.attachNBA')->middleware('upload.games');
Route::post('/games/{game}/delete', 'App\Http\Controllers\GamesController@destroy')->name('games.delete');
Route::get('/games/uploadPL/{matchDay}', 'App\Http\Controllers\GamesController@uploadPLGames')->name('games.uploadPLGames')->middleware('upload.games');
Route::get('/games/attach/PL/{league}', 'App\Http\Controllers\GamesController@attachPLGames')->name('games.attachPL')->middleware('upload.games');
Route::get('/games/test/{leagueType}', 'App\Http\Controllers\GamesController@test')->name('games.test');
