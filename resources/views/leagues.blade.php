@extends('layouts.app')

@section('content')
  <h1>Līgas</h1>
  <p> Šeit ies informācija par līgām(sākumā vērs līgu kopskatu)</p>
  <div class="card-body">
    <a href="{{route('leagues.create')}}">
      <button type="button" class="btn btn-primary float-right">Izveidot līgu</button>
    </a>
  </div>
  <div class="card-body">
    <a href="{{route('leagues.join')}}">
      <button type="button" class="btn btn-primary float-right">Pievienoties līgai</button>
    </a>
  </div>
@endsection
