@extends('layouts.app')

@section('content')
<h1>"{{$league->name}}" spēles</h1>

<div class="card-body">
  <table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">Spēles ID</th>
      <th scope="col">Mājas komanda</th>
      <th scope="col">Viesu komanda</th>
      <th scope="col">Rezultāts</th>
      <th scope="col">Spēles laiks</th>
    </tr>
  </thead>
  <tbody>
    @foreach($games as $game)
      @if($league->private != true)
      <tr>
        <td>{{$game->id}}</td>
        <td>{{$game->home_team}}</td>
        <td>{{$game->away_team}}</td>
        <td>3-2</td>
        <td>{{$game->start_time}}</td>
      </tr>
      @endif
    @endforeach
  </tbody>
</table>
</div>
@endsection
