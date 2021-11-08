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
}
