<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Game;
use App\Models\League;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DateTime;

class ResultsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //test code to output result of TBL-PHI game from 2021-11-23 from NHL API
        /*$date = "2021-11-23";
        $test = Http::get('http://statsapi.web.nhl.com/api/v1/schedule?date=' . $date);
        $test = json_decode($test);
        $teams = $test->dates[0]->games[0]->teams;
        $home_points = $teams->home->score;
        $away_points = $teams->away->score;
        return "Score of the game between " . $teams->home->team->name . " and " . $teams->away->team->name . " was " . $home_points . '-' . $away_points;
        */

        $user = auth()->user();
        $predictions = $user->predictions()->get()->toArray();
        $leagues = $user->getLeagues();
        return view('results.index')->with(['predictions' => $predictions, 'leagues' => $leagues]);
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
    //R-002
    public function getNHLResults()
    {
      //to get startDate for request, find earliest unprocessed game in games table for NHL league
      $league = League::find(1);
      $firstGame = $league->games()->where('ended', false)->first();
      $firstGameStart = $firstGame->start_time;
      $startDate = date('Y-m-d', strtotime("$firstGameStart - 24hours"));
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
            $startDate = $game->gameDate;
            $startDate = $startDate . '2 hours';
            //check if result for this game has already been entered
            if(!Result::where('game_id',$game_id)->first()){
              //create new result entry in database
              Result::create(['home_team'      => $home_team,
                            'away_team'        => $away_team,
                            'home_team_points' => $home_team_points,
                            'away_team_points' => $away_team_points,
                            'game_id'          => $game_id,
                            'start_time'       => date('Y-m-d H:i', strtotime($startDate))]);

              //update game status in database to ended = true
              Game::where('external_game_id', $game_pk)->update(['ended'=>true]);
              $gameCounter += 1;
              //process all predictions related to this game using the newly retrieved result
              Game::where('external_game_id', $game_pk)->first()->processResult($home_team_points, $away_team_points);
            }
          }
        }
      }
      return redirect()->route('home')->withSuccess('Rezultāti veiksmīgi ielādēti ' . $gameCounter . ' NHL spēlēm!');
    }
    //R-003
    public function league($user, League $league)
    {
      $user = User::find($user);
      $predictions = $user->predictions()->where('league_id', $league->id)->get()->toArray();
      $games = $league->games()->where('ended',1)->orderBy('start_time', 'desc')->paginate(10);
      return view('results.league')->with(['predictions' => $predictions, 'league' => $league, 'games' => $games, 'user' => $user]);
    }
}
