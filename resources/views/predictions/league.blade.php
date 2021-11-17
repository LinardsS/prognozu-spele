@extends('layouts.app')

@section('content')
<?php use App\Models\Game;?>

<div class="card-body">
  <table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">Spēles laiks</th>
      <th scope="col">Spēle</th>
      <th scope="col">Jūsu prognoze</th>
    </tr>
  </thead>

  <tbody>
    @foreach($games as $game)
      <?php $prediction = $game->getPrediction($user,$league)->first(); ?>
      <tr>
        <td>{{$game['start_time']}}</td>
        <td>{{$game['home_team']}} - {{$game['away_team']}}</td>
        @if($prediction)
        <td><input type="number" name="home_points" value= <?php echo $prediction->home_team_points ?> min="0" style="width: 50px;"> <input type="number" name="away_points" value=<?php echo $prediction->away_team_points ?> min="0" style="width: 50px;"></td>
        @else
        <td><input type="number" name="home_points" min="0" style="width: 50px;"> <input type="number" name="away_points" min="0" style="width: 50px;"></td>
        @endif
      </tr>
    @endforeach
  </tbody>
</table>
</div>
@endsection
