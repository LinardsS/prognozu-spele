<?php

namespace App\Http\Controllers;

use App\Models\Prediction;
use App\Models\Game;
use App\Models\League;
use Illuminate\Http\Request;
use DateTime;
use DateInterval;

class PredictionsController extends Controller
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
        $user = auth()->user();
        $predictions = $user->predictions()->get()->toArray();
        $leagues = $user->getLeagues();
        return view('predictions.index')->with(['predictions' => $predictions, 'leagues' => $leagues]);
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
     * @param  \App\Models\Prediction  $prediction
     * @return \Illuminate\Http\Response
     */
    public function show(Prediction $prediction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prediction  $prediction
     * @return \Illuminate\Http\Response
     */
    public function edit(Prediction $prediction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prediction  $prediction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prediction $prediction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prediction  $prediction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prediction $prediction)
    {
        //
    }
    //P-002
    public function league(League $league)
    {
      $user = auth()->user();
      $date = new DateTime();
      $date->add(new DateInterval('PT2H'));
      $predictions = $user->predictions()->where('league_id', $league->id)->get()->toArray();
      $games = $league->games()->where('ended',0)->where('start_time', '>', $date)->orderBy('start_time', 'asc')->paginate(20);
      return view('predictions.league')->with(['predictions' => $predictions, 'league' => $league, 'games' => $games, 'user' => $user]);
    }
    //P-001
    public function submit(Request $request)
    {
      //predictions for "Score" type leagues
      if($request->input('predictionType') == "Score"){
        foreach ($request->input('points', []) as $id => $points) {
          $prediction = Prediction::where(['game_id' => $id, 'user_id' => $request->user_id, 'league_id' => $request->league_id])->first();
          if($prediction){
            Prediction::where(['game_id' => $id, 'user_id' => $request->user_id, 'league_id' => $request->league_id])->update($points);
          }
          else{
            if($points['home_team_points'] != null && $points['away_team_points'] != null){
              $prediction = new Prediction;
              $prediction->home_team_points = $points['home_team_points'];
              $prediction->away_team_points = $points['away_team_points'];
              $prediction->user_id = $request->user_id;
              $prediction->league_id = $request->league_id;
              $prediction->game_id = $id;
              $prediction->save();
            }
          }
        }
      }
      else{
        foreach ($request->input('winner', []) as $id => $winner) {
          $prediction = Prediction::where(['game_id' => $id, 'user_id' => $request->user_id, 'league_id' => $request->league_id])->first();
          if($prediction){
            Prediction::where(['game_id' => $id, 'user_id' => $request->user_id, 'league_id' => $request->league_id])->update($points);
          }
          else{
            if($winner != null){
              $prediction = new Prediction;
              if($winner[0] == 1){
                $prediction->home_team_points = 1;
                $prediction->away_team_points = 0;
              }
              else if($winner[0] == 0){
                $prediction->home_team_points = 0;
                $prediction->away_team_points = 1;
              }
              $prediction->user_id = $request->user_id;
              $prediction->league_id = $request->league_id;
              $prediction->game_id = $id;
              $prediction->save();
            }
          }
        }
      }
      return redirect()->route('predictions.index')->withSuccess('Prognozes veiksmīgi saglabātas!');
    }
}
