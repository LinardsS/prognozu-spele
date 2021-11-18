@extends('layouts.app')

@section('content')
<?php use App\Models\Game;?>

{!! Form::open(['route' => 'predictions.submit']) !!}
<div class="card-body">
  <table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">Spēles laiks</th>
      <th scope="col">Spēle</th>
      <th scope="col">Jūsu prognoze</th>
    </tr>
  </thead>

  <tbody>
    @foreach($games as $game)
      <?php $prediction = $game->getPrediction($user,$league)->first(); ?>
      <tr>
        <td>{{$game['start_time']}} <input type="number" name="league_id" value="{{$league->id}}" hidden> <input type="number" name="user_id" value="{{$user->id}}" hidden></td>
        <td>{{$game['home_team']}} - {{$game['away_team']}}</td>
        @if($prediction)
        <td><input type="number" name="points[{{$game->id}}][home_team_points]" value= "{{$prediction->home_team_points}}" min="0" style="width: 50px;"> - <input type="number" name="points[{{$game->id}}][away_team_points]" value="{{$prediction->away_team_points}}" min="0" style="width: 50px;"></td>
        @else
        <td><input type="number" name="points[{{$game->id}}][home_team_points]" min="0" style="width: 50px;"> - <input type="number" name="points[{{$game->id}}][away_team_points]" min="0" style="width: 50px;"></td>
        @endif
      </tr>
    @endforeach
  </tbody>
</table>
</div>

<div>
  {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
</div>
{!! Form::close() !!}
@endsection
