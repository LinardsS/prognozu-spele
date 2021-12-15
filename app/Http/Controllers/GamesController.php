<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\League;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class GamesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //S-002
    public function uploadNHLGames($startDate, $endDate)
    {
      $schedule = Http::get('http://statsapi.web.nhl.com/api/v1/schedule?startDate=' . $startDate . '&endDate=' . $endDate);
      $dates = json_decode($schedule)->dates;
      $result = [];
      foreach ($dates as $date) {
        $games = $date->games;
        foreach($games as $game){

          $gameId = strval($game->gamePk);
          $startDate = $game->gameDate;
          $startDate = $startDate . '2 hours'; //add 2 hours to match Latvian GMT+2 time
          $home = $game->teams->home->team->name;
          $away = $game->teams->away->team->name;

          Game::create(['home_team' => $home,
                        'away_team' => $away,
                        'start_time' => date('Y-m-d H:i', strtotime($startDate)),
                        'ended'      => false,
                        'external_game_id' => $gameId,
                        'league_type' => "NHL"]);
        }
      }
    }
    //S-003
    public function attachNHLGames($league)
    {
      $league = League::where('id',$league)->first();
      $games = Game::where(['league_type' => 'NHL', 'ended' => 0])->get();
      $gameCounter = 0;
      foreach($games as $game){
          if (!$league->games()->where('game_id', '=', $game->id)->exists()) {
            $league->games()->attach($game);
            $gameCounter += 1;
          }
        }
      if($gameCounter != 0){
        return redirect()->route('home')->withSuccess('Veiksmīgi ielādētas ' . $gameCounter . ' NHL spēles līgai ar ID= '. $league->id. '!');
      }
      else{
        return redirect()->route('home')->withErrors(["msg" => "Šai līgai jau ir pievienotas NHL spēles!"]);
      }
    }

    public function uploadNBAGames($startDate, $endDate)
    {
      $gamesCounter = 0;
      $idArray = [];
      $request = Http::get('http://www.balldontlie.io/api/v1/games?start_date='. $startDate .'&end_date='. $endDate .'&per_page=100');
      $requestArray = json_decode($request,true);
      $data = $requestArray['data'];
      foreach($data as $game){
        $gameId = $game['id'];
        $gameId = strval($gameId);
        $gameDate = $game['date'];
        $gameDate = substr($gameDate,0,-14);
        $gameTime = $game['status']; // for scheduled game holds game time value
        $gameTime = substr($gameTime, 0, -3);
        if($gameTime == "Final"){
          continue;
        }
        else{
          $subtractHours = "- 5hours";
          if($gameTime == "12:00 PM ET"){
            $subtractHours = "- 12hours";
          }
          $gameTime = substr($gameTime, 0, -3);
          if(!Game::where('external_game_id', $gameId)->first()){
            Game::create(['home_team' =>  $game['home_team']['full_name'],
                          'away_team' =>  $game['visitor_team']['full_name'],
                          'start_time' => date('Y-m-d H:i', strtotime("$gameDate . $gameTime.  $subtractHours")),
                          'ended'      => false,
                          'external_game_id' => $gameId,
                          'league_type' => "NBA"]);
            $gamesCounter += 1;
            $idArray[] = $gameId;
          }
        }
      }

      // check page count of request result
      $pageCount = $requestArray['meta']['total_pages'];
      // if more than one page, loop through the rest
      for($i = 2; $i <= $pageCount; $i++){
        $requestString = 'http://www.balldontlie.io/api/v1/games?start_date='. $startDate .'&end_date='. $endDate .'&page='. $i .'&per_page=100';
        $loopRequest = Http::get($requestString);
        $loopArray = json_decode($loopRequest,true);
        $loopData = $loopArray['data'];
        foreach($loopData as $game){
          $gameId = $game['id'];
          $gameId = strval($gameId);
          if(!in_array($gameId, $idArray)){
            $gameArray = [];
            $gameDate = $game['date'];
            $gameDate = substr($gameDate,0,-14);
            $gameTime = $game['status']; // for scheduled game holds game time value
            if($gameTime == "Final"){
              continue;
            }
            else{
              $subtractHours = "- 5hours";
              if($gameTime == "12:00 PM ET"){
                $subtractHours = "- 12hours";
              }
              $gameTime = substr($gameTime, 0, -3);

              if(!Game::where('external_game_id', $gameId)->first()){
                Game::create(['home_team' =>  $game['home_team']['full_name'],
                              'away_team' =>  $game['visitor_team']['full_name'],
                              'start_time' => date('Y-m-d H:i', strtotime("$gameDate . $gameTime.  $subtractHours")),
                              'ended'      => false,
                              'external_game_id' => $gameId,
                              'league_type' => "NBA"]);
                $gamesCounter += 1;
                $idArray[] = $gameId;
              }
            }

          }
        }
      }
      return redirect()->route('home')->withSuccess('Veiksmīgi ielādētas ' . $gamesCounter . ' NBA spēles!');
    }

    public function destroy(Game $game)
    {
        $game->delete();

        return redirect()->back()->withSuccess('Spēle dzēsta veiksmīgi!');
    }
}
