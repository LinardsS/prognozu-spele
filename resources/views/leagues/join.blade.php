@extends('layouts.app')

@section('content')
  <h2>Ievadiet līgas kodu: </h2>
  {!! Form::open(['route' => 'leagues.joinByKey']) !!}
    <div class="form-group">
      {{Form::label('key', 'Līgas kods:');}}
      {{Form::text('key');}}
    </div>

    <div>
      {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    </div>
  {!! Form::close() !!}
@endsection
