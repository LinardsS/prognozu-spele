@extends('layouts.app')

@section('content')
  <h1>Prognozes</h1>
  <?php use App\Models\Game;?>
  @foreach($predictions as $prediction)
    <?php $game = Game::find($prediction['game_id']); ?>
    {{$game->home_team}} pret {{$game->away_team}}
  @endforeach

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
            <a href="{{route('predictions.league', $league['id'])}}">
              {{$league['name']}}
            </a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  </div>
@endsection
