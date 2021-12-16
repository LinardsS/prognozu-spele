@extends('layouts.app')

@section('content')
  {!! Form::open(['route' => 'leagues.submit']) !!}
  <h1>Izveidot līgu</h1>
    <div class="form-group">
      {{Form::label('name', 'Līgas nosaukums');}}
      {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Ievadiet līgas nosaukumu']);}}
    </div>
    <div class="form-group">
      {{Form::label('maxPlayers', 'Maksimālais dalībnieku skaits');}}
      {{Form::number('maxPlayers');}}
    </div>
    <div class="form-group">
      {{Form::label('description', 'Apraksts');}}
      {{Form::textarea('description', '', ['class' => 'form-control', 'placeholder' => 'Ievadiet īsu aprakstu par šo līgu']);}}
    </div>
    <div class="form-group">
      {{Form::label('private', 'Slēgta/atvērta līga');}}
      {{Form::select('private', array(0 => 'Atvērta', 1 => 'Slēgta'));}}
    </div>
    <div class="form-group">
      {{Form::label('predictionType', 'Prognožu veids');}}
      {{Form::select('predictionType', array('Win' => 'Uzvarētājs', 'Score' => 'Rezultāts'));}}
    </div>

    <div>
      {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    </div>
  {!! Form::close() !!}
@endsection
