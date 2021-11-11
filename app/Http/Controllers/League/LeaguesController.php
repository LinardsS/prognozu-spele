<?php

namespace App\Http\Controllers\League;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\League;
use Illuminate\Http\Request;

class LeaguesController extends Controller
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
        $leagues = League::all();
        $user = auth()->user();
        return view('leagues.index')->with(['leagues' => $leagues, 'user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('leagues.create');
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(League $league, User $user)
    {
        $user = auth()->user();
        return view('leagues.single')->with(['league' => $league, 'user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function join(Request $request, League $league)
    {
      $user = User::find($request->user);
      $league->users()->save($user);
      return view('leagues.single')->with(['league' => $league, 'user' => $user]);
    }

    public function submit(Request $request)
    {
      $this->validate($request, [
        'name' => 'required',
        'maxPlayers' => 'required',
        'scoring' => 'required',
        'private' => 'required',
        'predictionType' => 'required'
      ]);
      // Create new league
      $league = new League;
      $league->name = $request->input('name');
      $league->maxPlayers = $request->input('maxPlayers');
      $league->description = $request->input('description');
      $league->scoring = $request->input('scoring');
      $league->private = $request->input('private');
      $league->predictionType = $request->input('predictionType');
      $league->join_key = \Str::random(6);
      //owner of league = > logged in user
      $user = auth()->user();
      $league->owner_id = $user->id;
      //Save message
      $league->save();

      //Redirect
      return redirect('/')->withSuccess('Līga veiksmīgi izveidota');
    }

    public function joinKey()
    {
      return view('leagues.join');
    }

    public function joinByKey(Request $request)
    {
      $this->validate($request, [
        'key' => 'required',
      ]);
      $joinKey = $request->input('key');
      $league = League::where('join_key', $joinKey)->first();

      if($league){
        $user = auth()->user();
        $league->users()->save($user);

        return view('leagues.single')->with(['league' => $league, 'user' => $user]);
      }
      else{
        return redirect('/leagues/joinKey')->withErrors(['msg' => 'Ievadītais līgas kods neeksistē!']);
      }
    }

    public function leave(Request $request, League $league)
    {
      $user = User::find($request->user);
      $user->leagues()->detach($league);
      return redirect('/leagues')->withSuccess('Līga veiksmīgi pamesta!');
    }
}
