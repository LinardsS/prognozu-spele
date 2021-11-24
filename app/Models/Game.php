<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['home_team', 'away_team', 'start_time', 'ended', 'external_game_id', 'league_type'];
    use HasFactory;
    public function predictions()
    {
        return $this->hasMany('App\Models\Prediction');
    }

    public function getPrediction($user,$league)
    {
      return $this->predictions()->where([['user_id', '=', $user->id], ['league_id', '=', $league->id]])->get();
    }

    public function result()
    {
        return $this->hasOne('App\Models\Result');
    }
}
