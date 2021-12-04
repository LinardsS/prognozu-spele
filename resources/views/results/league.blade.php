@extends('layouts.app')

@section('content')
<?php use App\Models\Game;?>
<h3>Lietotāja {{$user->name}} prognozes līgā {{$league->name}}</h3>
<div class="card-body">
  <table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">Spēles laiks</th>
      <th scope="col">Spēle</th>
      <th scope="col">Spēles rezultāts</th>
      <th scope="col">Jūsu prognoze</th>
      <th scope="col">Punkti</th>
    </tr>
  </thead>

  <tbody>
    @foreach($games as $game)
      <?php $prediction = $game->getPrediction($user,$league)->first(); ?>
      <tr>
        <td>{{date('d-m-Y H:i', strtotime($game['start_time']))}}</td>
        <td>{{$game['home_team']}} - {{$game['away_team']}}</td>
        <td><?php $result =$game->getResult();
                  $r_home = $result->home_team_points;
                  $r_away = $result->away_team_points;  ?>{{$r_home}} - {{$r_away}}</td>
        @if($prediction)
        <td>{{$prediction->home_team_points}} - {{$prediction->away_team_points}}</td>
        <td>@if($game->evaluateResult($prediction->home_team_points, $prediction->away_team_points, $r_home, $r_away))
            {{$result->getPredictionScore($league->predictionType, $prediction->home_team_points, $prediction->away_team_points)}}
            @else
            0
            @endif</td>
        @else
        <td> - </td>
        <td>0</td>
        @endif
      </tr>
    @endforeach
  </tbody>
</table>
{{$games->links()}}
</div>

<div>
</div>
@endsection
