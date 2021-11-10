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
    <a href="{{route('leagues.joinKey')}}">
      <button type="button" class="btn btn-primary float-right">Pievienoties līgai</button>
    </a>
  </div>
  <h2>Publiskās līgas</h2>
  <div class="card-body">
    @foreach($leagues as $league)
      @if($league->private != true)
        <a href="{{route('leagues.show', $league)}}">
          {{$league->name}} - {{$league->description}}
        </a>
        <br>
      @endif
    @endforeach
  </div>
  Lietotāja <strong>{{$user->name}}</strong> līgas:
  {{ implode(', ', $user->leagues()->get()->pluck('name')->toArray())}}
@endsection
