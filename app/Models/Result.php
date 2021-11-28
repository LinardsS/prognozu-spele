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
}
