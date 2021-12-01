<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Prediction;
use App\Models\User;
use App\Models\League;
use App\Models\Result;

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

    public function processResult($home_team_points, $away_team_points)
    {
      $predictions = Prediction::where('game_id',$this->id)->get();
      $gd = $home_team_points - $away_team_points; //goal difference used to determine who won

      foreach($predictions as $prediction ){
        $home_prediction = $prediction->home_team_points;
        $away_prediction = $prediction->away_team_points;
        $gd_prediction = $home_prediction - $away_prediction;

        //if goal difference same polarity(positive/negative), then winner correctly predicted
        if(($gd_prediction > 0 && $gd > 0) || ($gd_prediction < 0 && $gd < 0)){
          $league = League::find($prediction->league_id);
          $user_id = $prediction->user_id;
          $user = User::find($user_id);
          $points = $league->users()->where('user_id', $user_id)->first()->pivot->points;
          //determine if league awards points based on picking winner or correct score
          $predictionType = $league->predictionType;
          if($predictionType == "Win"){
            $league->users()->updateExistingPivot($user, array('points' => $points+1), true);
          }
          if($predictionType == "Score"){
            //determine by how much to increase user point total

            //if both team totals predicted correctly, score is predicted correctly, award full points
            if($home_team_points == $home_prediction && $away_team_points == $away_prediction){
              $league->users()->updateExistingPivot($user, array('points' => $points+10), true);
            }
            //if score not predicted correctly, but goal difference correct, award half of full points
            else if($gd == $gd_prediction){
              $league->users()->updateExistingPivot($user, array('points' => $points+5), true);
            }
            //award 3 points for correctly picking winner
            else{
              $league->users()->updateExistingPivot($user, array('points' => $points+3), true);
            }
          }
        }
      }
    }

    public function getResult()
    {
      return $result = Result::where('game_id', $this->id)->first();
    }

    public function evaluateResult($p_home, $p_away, $r_home, $r_away)
    {
      $p_gd = $p_home - $p_away; //predicted goal difference
      $r_gd = $r_home - $r_away; //result goal difference

      if(($p_gd > 0 && $r_gd > 0) || ($p_gd < 0 && $r_gd  < 0)){
        return true;
      }
      else{
        return false;
      }
    }
}
