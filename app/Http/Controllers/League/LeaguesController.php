<?php

namespace App\Http\Controllers\League;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\League;
use App\Models\Game;
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
      if($league->countMembers() == $league->maxPlayers){
        return redirect('/leagues')->withErrors(['msg' => 'Līgai nevar pievienoties, jo tā sasniegusi maksimālo spēlētāju skaitu!']);
      }
      else{
        $league->users()->save($user);
        return view('leagues.single')->with(['league' => $league, 'user' => $user]);
      }
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

      //add creator of league to league
      $league->users()->save($user);
      //Redirect
      return redirect()->route('leagues.index')->withSuccess('Līga veiksmīgi izveidota');
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
        if($league->countMembers() == $league->maxPlayers){
          return redirect('/leagues')->withErrors(['msg' => 'Līgai nevar pievienoties, jo tā sasniegusi maksimālo spēlētāju skaitu!']);
        }
        else{
          $user = auth()->user();
          $league->users()->save($user);

          return view('leagues.single')->with(['league' => $league, 'user' => $user]);
        }
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

    public function showGames(League $league)
    {
      $games = $league->games()->get();
      return view('leagues.games')->with(['league' => $league, 'games' => $games]);
    }

    public function addGames(League $league)
    {
      return view('leagues.addGames')->with(['league' => $league]);
    }

    public function submitGame(Request $request)
    {
      $this->validate($request, [
        'home_team' => 'required',
        'away_team' => 'required',
        'start_date' => 'required',
        'start_time' => 'required',
      ]);

      $game = new Game;
      $game->home_team = $request->input('home_team');
      $game->away_team = $request->input('away_team');
      //combine start date with start time to create start_time
      $date = $request->input('start_date');
      $time = $request->input('start_time');
      $start_time = date('Y-m-d H:i:s', strtotime("$date $time"));
      $game->start_time = $start_time;

      $game->ended = false;
      $game->save();

      //add relation between game and league
      $league = League::find($request->input('league_id'))->first();
      $league->games()->save($game);
      return redirect()->route('leagues.addGames', $league)->withSuccess('Spēle veiksmīgi pievienota!');
    }

    public function deleteUser(League $league, User $user)
    {
        $league->users()->where('user_id', $user->id)->detach($user);

        $owner = auth()->user();
        return redirect()->route('leagues.show', $league)->withSuccess('Lietotājs veiksmīgi dzēsts!');
    }
}
