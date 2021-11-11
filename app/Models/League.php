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
      return $this->belongsToMany('App\Models\User');
    }

    public function getUsers()
    {
      $users = $this->users()->where('user_id', '>', 0)->get();
      $array = [];

      foreach($users as $user){
        $subarray = [];
        $subarray['name'] = $user['name'];
        $subarray['id'] = $user['id'];
        array_push($array, $subarray);
      }
      return $array;
    }
}
