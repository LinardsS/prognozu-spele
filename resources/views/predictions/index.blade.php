@extends('layouts.app')

@section('content')
  <h1>Prognozes</h1>
  <?php use App\Models\Game;?>
  @foreach($predictions as $prediction)
    <?php $game = Game::find($prediction['game_id']); ?>
    {{$game->home_team}} pret {{$game->away_team}}
  @endforeach
@endsection
