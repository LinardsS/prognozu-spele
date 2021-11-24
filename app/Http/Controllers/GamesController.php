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

    public function attachNHLGames()
    {
      $league = League::find(1)->first();
      for($x = 1; $x <= 200; $x++){
        $game = Game::where('id', $x)->first();
        if($game){
          $league->games()->attach($game);
        }
      }

    }

}
