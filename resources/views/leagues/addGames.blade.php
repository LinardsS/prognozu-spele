@extends('layouts.app')

@section('content')
  {!! Form::open(['route' => 'leagues.submitGame']) !!}
  <h2>Pievienot spēles līgai: {{$league->name}}</h2>
  <input type="number" name="league_id" value="{{$league->id}}" hidden>
    <div class="form-group">
      {{Form::label('home_team', 'Mājnieku komanda');}}
      {{Form::text('home_team', '', ['class' => 'form-control', 'placeholder' => 'Ievadiet mājnieku komandu']);}}
    </div>
    <div class="form-group">
      {{Form::label('away_team', 'Viesu komanda');}}
      {{Form::text('away_team', '', ['class' => 'form-control', 'placeholder' => 'Ievadiet viesu komandu']);}}
    </div>
    <div class="form-group">
      {{Form::label('start_date', 'Spēles diena');}}
      {{Form::text('start_date', '', ['class' => 'form-control', 'id' => 'datepicker']);}}
    </div>
    <div class="form-group">
      {{Form::label('start_time', 'Spēles laiks');}}
      {{Form::text('start_time', '', ['class' => 'form-control', 'id' => 'timepicker']);}}
    </div>

    <div>
      {{Form::submit('Izveidot', ['class' => 'btn btn-primary'])}}
    </div>
  {!! Form::close() !!}
@endsection
