<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    use HasFactory;
    public $timestamps = true;

    public function users()
    {
      return $this->belongsToMany('App\Models\User')->withPivot('points')->withTimestamps();
    }

    public function getUsers()
    {
      $users = $this->users()->where('user_id', '>', 0)->orderBy('pivot_points', 'desc')->get();
      $array = [];

      foreach($users as $user){
        $subarray = [];
        $subarray['name'] = $user['name'];
        $subarray['id'] = $user['id'];
        array_push($array, $subarray);
      }
      return $array;
    }

    public function games()
    {
      return $this->belongsToMany('App\Models\Game');
    }

    public function isPrivate()
    {
      if($this->private == '1'){
        return true;
      }
      return false;
    }

    public function countMembers()
    {
      $users = $this->users()->where('user_id', '>', 0)->get();
      $count = 0;

      foreach($users as $user)
      {
        $count += 1;
      }

      return $count;
    }

    public function getPointsCount($user_id)
    {
      return $this->users()->where('user_id', $user_id)->first()->pivot->points;
    }
}
