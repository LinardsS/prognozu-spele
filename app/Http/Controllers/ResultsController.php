<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DateTime;

class ResultsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //test code to output result of TBL-PHI game from 2021-11-23 from NHL API
        //$results = Result::all();
        $date = "2021-11-23";
        $test = Http::get('http://statsapi.web.nhl.com/api/v1/schedule?date=' . $date);
        $test = json_decode($test);
        $teams = $test->dates[0]->games[0]->teams;
        $home_points = $teams->home->score;
        $away_points = $teams->away->score;
        return "Score of the game between " . $teams->home->team->name . " and " . $teams->away->team->name . " was " . $home_points . '-' . $away_points;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function show(Result $result)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function edit(Result $result)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Result $result)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Result  $result
     * @return \Illuminate\Http\Response
     */
    public function destroy(Result $result)
    {
        //
    }

    public function getPLResult($matchDay){
      $authKey = "5dd4dc55b02c40888d7fba33f492599b";
      $response = Http::withHeaders(['X-Auth-Token' => $authKey])->get('http://api.football-data.org/v2/competitions/PL/matches/?matchday' . $matchDay);
      return $response;
    }

    public function getNHLResults($startDate)
    {
      $endDate = new DateTime();
      $endDate = $endDate->format('Y-m-d');
      $request = Http::get('http://statsapi.web.nhl.com/api/v1/schedule?startDate=' . $startDate . '&endDate=' . $endDate);
      $dates = json_decode($request)->dates;
      $output = [];
      $gameCounter = 0;
      foreach ($dates as $date) {
        $games = $date->games;
        foreach($games as $game){
          $gameState = $game->status->codedGameState;

          if($gameState == '7'){ // 7- game finished
            $home_team = $game->teams->home->team->name;
            $away_team = $game->teams->away->team->name;
            $home_team_points = $game->teams->home->score;
            $away_team_points = $game->teams->away->score;
            $game_pk = strval($game->gamePk);
            $game_id = Game::where('external_game_id', $game_pk)->value('id');
            //check if result for this game has already been entered
            if(!Result::where('game_id',$game_id)->first()){
              //create new result entry in database
              Result::create(['home_team'      => $home_team,
                            'away_team'        => $away_team,
                            'home_team_points' => $home_team_points,
                            'away_team_points' => $away_team_points,
                            'game_id'          => $game_id]);

              //update game status in database to ended = true
              Game::where('external_game_id', $game_pk)->update(['ended'=>true]);
              $gameCounter += 1;
            }
          }
        /*  Game::create(['home_team' => $home,
                        'away_team' => $away,
                        'start_time' => date('Y-m-d H:i', strtotime($startDate)),
                        'ended'      => false,
                        'external_game_id' => $gameId,
                        'league_type' => "NHL"]);*/
        }
      }
      return redirect()->route('home')->withSuccess('Rezultāti veiksmīgi ielādēti ' . $gameCounter . ' NHL spēlēm!');
    }
}
