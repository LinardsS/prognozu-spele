@extends('layouts.app')

@section('content')
<h1>"{{$league->name}}" spēles</h1>
<br>
<ul class="nav nav-pills nav-justified">
  <li class="nav-item">
    <a class="nav-link" aria-current="page" href="{{route('leagues.games', $league->id)}}">Tuvākās spēles</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" href="#">Rezultāti</a>
  </li>
</ul>
<p>{{$games}}</p>
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
      <tr>
        <td>{{$game->id}}</td>
        <td>{{$game->home_team}}</td>
        <td>{{$game->away_team}}</td>
        @if($game->ended)
        <?php $result = $game->result()->first(); ?>
          @if($result)
          <td>{{$result->home_team_points}}-{{$result->away_team_points}}</td>
          @else
          <td></td>
          @endif
        @else
        <td></td>
        @endif
        <td>{{date('d-m-Y H:i', strtotime($game->start_time))}}</td>
      </tr>
    @endforeach
  </tbody>
</table>
{{$games->links()}}
</div>
@endsection
