<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function getHome(){
      return view('home');
    }

    public function getLeagues(){
      return view('leagues');
    }

    public function getRules(){
      return view('rules');
    }
}
