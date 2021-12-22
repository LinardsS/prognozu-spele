@extends('layouts.app')

@section('content')
  <h1>Prognožu līgas</h1>
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

  <h2>Lietotāja <strong>{{$user->name}}</strong> līgas</h2>
  <div class="card-body">
    <table class="table">
    <thead class="thead-light">
      <tr>
        <th scope="col">Līgas nosaukums</th>
        <th scope="col">Līgas apraksts</th>
        <th scope="col">Vieta</th>
      </tr>
    </thead>

    <tbody>
      <?php $userLeagues = $user->getLeagues(); ?>
      @foreach($userLeagues as $userLeague)
        <tr>
          <td>
            <a href="{{route('leagues.show', $userLeague['id'])}}">
              {{$userLeague['name']}}
            </a>
          </td>
          <td>{{$userLeague['description']}}</td>
          <td>{{$user->getPointTotal($userLeague['id'])}}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
  </div>
  <br>
  <h2>Publiskās līgas</h2>
  <div class="card-body">
    <table class="table">
    <thead class="thead-light">
      <tr>
        <th scope="col">Līgas nosaukums</th>
        <th scope="col">Līgas apraksts</th>
      </tr>
    </thead>
    <tbody>
      @foreach($leagues as $league)
        <tr>
          <td>
            <a href="{{route('leagues.show', $league)}}">
              {{$league->name}}
            </a>
          </td>
          <td>{{$league->description}}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
  {{$leagues->links()}}
  </div>
@endsection
