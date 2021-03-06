<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UploadGames
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if($user->id == 1){
            return $next($request);
        }
        else{
          return redirect()->back()->withErrors(['msg' => 'Jums nav tiesību piekļūt šai lapai!']);
        }
    }
}
