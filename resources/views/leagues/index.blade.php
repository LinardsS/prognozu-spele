@extends('layouts.app')

@section('content')
  <h1>Līgas</h1>
  <p> Šeit ies informācija par līgām(sākumā vērs līgu kopskatu)</p>
  <div class="card-body">
    <a href="">
      <button type="button" class="btn btn-primary float-right">Izveidot līgu</button>
    </a>
  </div>
  <div class="card-body">
    <a href="">
      <button type="button" class="btn btn-primary float-right">Pievienoties līgai</button>
    </a>
  </div>
  <h2>Publiskās līgas</h2>
  <div class="card-body">
    @foreach($leagues as $league)
      @if($league->private != true)
        <a href="/leagues/{{$league->id}}">
          {{$league->name}} - {{$league->description}}
        </a>
      @endif
    @endforeach
  </div>
@endsection
