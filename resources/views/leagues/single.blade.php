@extends('layouts.app')

@section('content')
  <h1>{{$league->name}}</h1>

  <p><strong>Apraksts: </strong>{{$league->description}}</p>
  <p><strong>Līgas punktu skaitīšanas sistēma: </strong> {{$league->scoring}}</p>
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
    <div class="container">
      <form method="POST" action="{{route('leagues.join', $league)}}">
        @csrf
        <input type="hidden" name="user" value="{{$user->id}}"> </input>
        <button type="submit" class="btn btn-primary float-right">Pievienoties līgai</button>
      </form>
    </div>
  @else
  <div class="container">
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
    </tr>
  </thead>
  <tbody>
    <?php $i = 0; ?>
    @foreach($users as $user)
    <tr>
      <th scope="row">{{$i=$i+1}}</th>
      <td><a href="{{route('admin.users.edit', $user->id)}}">{{$user->name}}</a></td>
      <td>{{305 - $user->id}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
