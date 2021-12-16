@extends('layouts.app')

@section('content')
  <h1>{{$league->name}}</h1>

  <p><strong>Apraksts: </strong>{{$league->description}}</p>
  <p><strong>Līgas punktu skaitīšanas sistēma: </strong> {{$league->predictionType}}</p>
  <p><strong>Maksimālais atļautais spēlētāju skaits: </strong> {{$league->maxPlayers}}</p>
  <p>
    Līga
    @if($league->private == false)
       <strong>nav</strong>
    @else
      <strong>ir</strong>
    @endif
     privāta
  </p>
  @if($user->isLeagueOwner($league->id))
  <p><strong>Līgas atslēga: </strong> {{$league->join_key}}</p>
  @endif
  @if(!$user->isInLeague($league->id))
    @if(!$league->isPrivate())
    <div class="container">
      <form method="POST" action="{{route('leagues.join', $league)}}">
        @csrf
        <input type="hidden" name="user" value="{{$user->id}}"> </input>
        <button type="submit" class="btn btn-primary float-right">Pievienoties līgai</button>
      </form>
    </div>
    @endif
  @else
  <div class="container">
    <a href="{{route('leagues.games', $league)}}"><button type="button" class="btn btn-primary float-left">Spēles</button></a>
    @if($user->isLeagueOwner($league->id) || (auth()->user()->id == 1))
    <a href="{{route('leagues.edit', $league)}}"><button type="button" class="btn btn-primary float-left">Rediģēt līgu</button></a>
    @endif
    <form method="POST" action="{{route('leagues.leave', $league)}}">
      @csrf
      <input type="hidden" name="user" value="{{$user->id}}"> </input>
      <button type="submit" class="btn btn-danger float-right">Pamest līgu</button>
    </form>
  </div>
  @endif
  <br>
  <br>
  <table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">Rangs</th>
      <th scope="col">Lietotājs</th>
      <th scope="col">Punktu skaits</th>
      <?php $showDelete = $user->isLeagueOwner($league->id); ?>
      @if($showDelete)
      <th scope="col"></th>
      @endif
    </tr>
  </thead>
  <tbody>
    <?php $i = 0;
      $users = $league->getUsers();
      use App\Models\User;
     ?>
    @foreach($users as $user)
    <tr>
      <th scope="row">{{$i=$i+1}}</th>
      <td><a href="{{route('results.league', ['user' => $user['id'], 'league' => $league['id']])}}">{{$user['name']}}</a></td>
      @if(!$showDelete)
      <td>{{$league->getPointsCount($user['id'])}}</td>
      @else
      <td>{{$league->getPointsCount($user['id'])}}<form class="" action="{{ route('leagues.deleteUser',[$league, User::find($user['id'])]) }}" method="post"></td>
        @csrf
        <td><button type="submit" class="btn btn-danger" style="align: right;">
           Dzēst
         </button></td>
      </form>
      @endif
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
