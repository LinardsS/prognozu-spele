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
