@extends('layouts.app')

@section('content')
<h1>"{{$league->name}}" spēles</h1>

<br>
<ul class="nav nav-pills nav-justified">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="#">Tuvākās spēles</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{route('leagues.results', $league->id)}}">Rezultāti</a>
  </li>
</ul>
@if(auth()->user()->isLeagueOwner($league->id))
<div class="card-body">
  <a href="{{route('leagues.addGames', $league)}}">
    <button type="button" class="btn btn-primary float-right">Pievienot spēles</button>
  </a>
</div>
@endif
<p>{{$games}}</p>
<div class="card-body">
  <table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">Spēles ID</th>
      <th scope="col">Mājas komanda</th>
      <th scope="col">Viesu komanda</th>
      <th scope="col">Spēles laiks</th>
      @if(auth()->user()->isLeagueOwner($league->id))
      <th scope="col"></th>
      <th scope="col"></th>
      @endif
    </tr>
  </thead>
  <tbody>
    @if(auth()->user()->isInLeague($league->id))
    @foreach($games as $game)
      <tr>
        <td>{{$game->id}}</td>
        <td>{{$game->home_team}}</td>
        <td>{{$game->away_team}}</td>
        <td>{{date('d-m-Y H:i', strtotime($game->start_time))}}</td>
        @if(auth()->user()->isLeagueOwner($league->id) && $game->isCustom())
        <td><a href="{{route('results.add', [$league, $game])}}"><button type="button" class="btn btn-primary float-left">Pievienot rezultātu</button></a></td>
        <form method="POST" action="{{route('games.delete', $game)}}">
          @csrf
          <td><button type="submit" class="btn btn-danger float-left">Dzēst spēli</button></td>
        </form>
        @elseif(!$game->isCustom() && auth()->user()->hasRole('admin'))
        <form method="POST" action="{{route('games.delete', $game)}}">
          @csrf
          <td><button type="submit" class="btn btn-danger float-left">Dzēst spēli</button></td>
        </form>
        @endif
      </tr>
    @endforeach
    @endif
  </tbody>
</table>
{{$games->links()}}
</div>
@endsection
