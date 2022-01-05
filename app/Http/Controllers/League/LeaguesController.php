<?php

namespace App\Http\Controllers\League;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\League;
use App\Models\Game;
use Illuminate\Http\Request;
use DB;

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
        $leagues = League::where('private', false)->paginate(15);
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
     * LE-003
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
    public function edit(League $league)
    {
        return view('leagues.edit')->with(['league' => $league]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, League $league)
    {
        // Count league users to see if change of maxPlayers can break the current state
        $leagueUsers = $league->users()->get();
        $userCount =  $leagueUsers->count();
        // If new maxPlayers number bigger than current number of players, throw error
        if($userCount > $request->maxPlayers){
          return redirect()->route('leagues.edit', ['league' => $league])->withErrors(['Maksimālais spēlētāju skaits nevar būt mazāks par pašlaik esošo spēlētāju skaitu!']);
        }
        else{
          $league->maxPlayers = $request->maxPlayers;
        }
        $league->name = $request->name;
        $league->description = $request->description;
        if($request->has('private') == 1 ){
          $league->private = 1;
        }
        else{
          $league->private = 0;
        }

        if($league->save()){
          $request->session()->flash('success', $league->name . ' veiksmīgi rediģēta');
        } else{
          $request->session()->flash('error', 'Notikusi kļūda rediģēšanas laikā!');
        }
        return redirect()->route('leagues.index');
    }
    //LE-010
    public function join(Request $request, League $league)
    {
      $user = User::find($request->user);
      if($league->countMembers() == $league->maxPlayers){
        return redirect('/leagues')->withErrors(['msg' => 'Līgai nevar pievienoties, jo tā sasniegusi maksimālo spēlētāju skaitu!']);
      }
      else{
        $league->users()->save($user);
        return redirect()->route('leagues.show', ['league' => $league, 'user' => $user])->withSuccess('Lietotājs veiksmīgi pievienojies līgai!');;
      }
    }
    //LE-001
    public function submit(Request $request)
    {
      $this->validate($request, [
        'name' => 'required',
        'maxPlayers' => 'required',
        'private' => 'required',
        'predictionType' => 'required'
      ]);

      // Create new league
      $league = new League;
      $league->name = $request->input('name');
      $league->maxPlayers = $request->input('maxPlayers');
      $league->description = $request->input('description');
      $league->scoring = "Classic";
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
      //add default league games(NHL, NBA, PL) if user has selected them
      if($request->has('leagues')){
        //get newly created league to which the games will get attached
        $newLeague = League::where('name', $request->input('name'))->first();
        $newLeagueId = $newLeague->id;
        $leagues = $request->input('leagues');
        if(in_array("1", $leagues)){      // NHL
          //add NHL
          app('App\Http\Controllers\GamesController')->attachNHLGames($newLeagueId);
          //attach league to league_association table which will ensure NHL game upload in future
          DB::insert('insert into league_association (league_id, league_type) values (:id, :type)', ['id' => $newLeagueId, 'type' => 'NHL' ]);
        }
        if(in_array("2", $leagues)){ // NBA
          //add NBA
          app('App\Http\Controllers\GamesController')->attachNBAGames($newLeagueId);
          //attach league to league_association table which will ensure NBA game upload in future
          DB::insert('insert into league_association (league_id, league_type) values (:id, :type)', ['id' => $newLeagueId, 'type' => 'NBA' ]);
        }
        if(in_array("3", $leagues)){
          //add PL
          app('App\Http\Controllers\GamesController')->attachPLGames($newLeagueId);
          //attach league to league_association table which will ensure PL game upload in future
          DB::insert('insert into league_association (league_id, league_type) values (:id, :type)', ['id' => $newLeagueId, 'type' => 'PL' ]);
        }
      }
      //Redirect
      return redirect()->route('leagues.index')->withSuccess('Līga veiksmīgi izveidota');
    }

    public function joinKey()
    {
      return view('leagues.join');
    }
    //LE-009
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
    //LE-004
    public function leave(Request $request, League $league)
    {
      $user = User::find($request->user);
      $user->leagues()->detach($league);
      return redirect('/leagues')->withSuccess('Līga veiksmīgi pamesta!');
    }
    //LE-007
    public function showGames(League $league)
    {
      $games = $league->games()->where('ended', 0)->orderBy('start_time','asc')->paginate(20);
      return view('leagues.games')->with(['league' => $league, 'games' => $games]);
    }

    public function addGames(League $league)
    {
      return view('leagues.addGames')->with(['league' => $league]);
    }
    //LE-006
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
      $league = League::where('id',$request->input('league_id'))->first();
      $league->games()->save($game);
      return redirect()->route('leagues.addGames', $league)->withSuccess('Spēle veiksmīgi pievienota!');
    }
    //LE-005
    public function deleteUser(League $league, User $user)
    {
        $league->users()->where('user_id', $user->id)->detach($user);

        $owner = auth()->user();
        return redirect()->route('leagues.show', $league)->withSuccess('Lietotājs veiksmīgi dzēsts!');
    }
    //LE-008
    public function showGamesResults(League $league)
    {
      $games = $league->games()->where('ended', 1)->orderBy('start_time','desc')->paginate(20);
      return view('leagues.results')->with(['league' => $league, 'games' => $games]);
    }

    public function detachGame(League $league, $game_id)
    {
      $game = Game::where('id', $game_id)->first();
      $league->games()->detach($game);
      return redirect()->back();
    }
}
