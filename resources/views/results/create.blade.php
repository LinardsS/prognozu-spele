@extends('layouts.app')

@section('content')
  {!! Form::open(['route' => 'results.submit']) !!}
  <h2>Pievienot spēles līgai: {{$league->name}}</h2>
  <input type="number" name="league_id" value="{{$league->id}}" hidden>
  <input type="number" name="game_id" value="{{$game->id}}" hidden>
    <div class="form-group">
      {{Form::label('home_team_points', 'Mājnieku komanda - '. $game->home_team);}}
      {{Form::number('home_team_points', '', ['class' => 'form-control', 'min'=>0])}}
    </div>
    <div class="form-group">
      {{Form::label('away_team_points', 'Viesu komanda - '. $game->away_team);}}
      {{Form::number('away_team_points', '', ['class' => 'form-control', 'min'=>0]);}}
    </div>
    <div>
      {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    </div>
  {!! Form::close() !!}
@endsection
