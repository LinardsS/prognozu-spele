<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
}
