<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = ['home_team', 'away_team', 'home_team_points', 'away_team_points', 'game_id', 'start_time'];
    public function game()
    {
        return $this->belongsTo('App\Models\Game');
    }

    public function getPredictionScore($scoring, $p_home, $p_away)
    {
      if($scoring == "Win")
      {
          return 1;
      }
      if($scoring == "Score")
      {
        $p_gd = $p_home - $p_away;         //predicted goal difference
        $r_home = $this->home_team_points; //actual result of home team
        $r_away = $this->away_team_points; //actual result of away team
        $r_gd = $r_home - $r_away;         //actual goal difference
        if($p_home == $r_home && $p_home == $r_away){
          return 10;
        }
        else if($p_gd == $r_gd){
          return 5;
        }
        else {
          return 3;
        }
      }
    }
}
