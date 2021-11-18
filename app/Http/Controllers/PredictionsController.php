<?php

namespace App\Http\Controllers;

use App\Models\Prediction;
use App\Models\Game;
use App\Models\League;
use Illuminate\Http\Request;

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

    public function league(League $league)
    {
      $user = auth()->user();
      $predictions = $user->predictions()->where('league_id',$league->id)->get()->toArray();
      $games = $league->games()->where('ended',0)->get();
      return view('predictions.league')->with(['predictions' => $predictions, 'league' => $league, 'games' => $games, 'user' => $user]);
    }

    public function submit(Request $request)
    {
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
      return redirect()->route('predictions.index')->withSuccess('Prognozes veiksmīgi saglabātas!');
    }
}
