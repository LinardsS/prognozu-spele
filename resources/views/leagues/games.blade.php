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
    </tr>
  </thead>
  <tbody>
    @foreach($games as $game)
      @if($league->private != true && auth()->user()->isInLeague($league->id))
      <tr>
        <td>{{$game->id}}</td>
        <td>{{$game->home_team}}</td>
        <td>{{$game->away_team}}</td>
        <td>{{date('d-m-Y H:i', strtotime($game->start_time))}}</td>
      </tr>
      @endif
    @endforeach
  </tbody>
</table>
{{$games->links()}}
</div>
@endsection
