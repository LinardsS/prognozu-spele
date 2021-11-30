@extends('layouts.app')

@section('content')
  <h1>Rezultāti</h1>

  <div class="card-body">
    <table class="table">
    <thead class="thead-light">
      <tr>
        <th scope="col">Līgas nosaukums</th>
      </tr>
    </thead>

    <tbody>
      @foreach($leagues as $league)
        <tr>
          <td>
            <a href="{{route('results.league', ['user' => auth()->user()->id, 'league' => $league['id']])}}">
              {{$league['name']}}
            </a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  </div>
@endsection
