<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles(){
      return $this->belongsToMany('App\Models\Role');
    }

    public function hasAnyRoles($roles){
      if($this->roles()->whereIn('name', $roles)->first()){
        return true;
      }

      return false;
    }

    public function hasRole($role){
      if($this->roles()->where('name', $role)->first()){
        return true;
      }

      return false;
    }

    public function leagues(){
      return $this->belongsToMany('App\Models\League')->withPivot('points')->withTimestamps();
    }

    public function isInLeague($league){
      if($this->leagues()->where('league_id', $league)->first()){
        return true;
      }

      return false;
    }

    public function isLeagueOwner($league)
    {
      $lig = $this->leagues()->where('league_id', $league)->first();
      if($lig){
        if($lig->owner_id == $this->id){
          return true;
        }
        else{
          return false;
        }
      }
      else{
        return false;
      }
    }

    public function getLeagues()
    {
      $leagues = $this->leagues()->where('league_id', '>', 0)->get();
      $array = [];

      foreach($leagues as $league){
        $subarray = [];
        $subarray['name'] = $league['name'];
        $subarray['id'] = $league['id'];
        $subarray['description'] = $league['description'];
        array_push($array, $subarray);
      }
      return $array;
    }

    public function predictions()
    {
      return $this->hasMany('App\Models\Prediction');
    }
}
