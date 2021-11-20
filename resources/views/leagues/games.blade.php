@extends('layouts.app')

@section('content')
<h1>"{{$league->name}}" spēles</h1>
@if(auth()->user()->isLeagueOwner($league->id))
<div class="card-body">
  <a href="{{route('leagues.addGames', $league)}}">
    <button type="button" class="btn btn-primary float-right">Pievienot spēles</button>
  </a>
</div>
@endif
<div class="card-body">
  <table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">Spēles ID</th>
      <th scope="col">Mājas komanda</th>
      <th scope="col">Viesu komanda</th>
      <th scope="col">Rezultāts</th>
      <th scope="col">Spēles laiks</th>
    </tr>
  </thead>
  <tbody>
    @foreach($games as $game)
      @if($league->private != true)
      <tr>
        <td>{{$game->id}}</td>
        <td>{{$game->home_team}}</td>
        <td>{{$game->away_team}}</td>
        @if($game->ended)
        <td>3-2</td>
        @else
        <td></td>
        @endif
        <td>{{$game->start_time}}</td>
      </tr>
      @endif
    @endforeach
  </tbody>
</table>
</div>
@endsection
