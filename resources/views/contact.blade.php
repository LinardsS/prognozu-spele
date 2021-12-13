@extends('layouts.app')

@section('content')
<?php $user = auth()->user(); ?>
  <h1>Saziņa</h1>
  {!! Form::open(['url' => 'contact/submit']) !!}
    <div class="form-group">
      {{Form::label('name', 'Vārds');}}
      {{Form::text('name', $user->name, ['class' => 'form-control', 'placeholder' => $user->name]);}}
    </div>
    <div class="form-group">
      {{Form::label('email', 'E-pasta adrese');}}
      {{Form::email('email', $user->email, ['class' => 'form-control', 'placeholder' =>  $user->email]);}}
    </div>
    <div class="form-group">
      {{Form::label('message', 'Ziņas saturs');}}
      {{Form::textarea('message', '', ['class' => 'form-control', 'placeholder' => 'Ievadiet ziņu']);}}
    </div>
    <div>
      {{Form::submit('Sūtīt', ['class' => 'btn btn-primary'])}}
    </div>
  {!! Form::close() !!}
@endsection
