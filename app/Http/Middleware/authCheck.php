<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class authCheck
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
        if(auth()->user() && ($request->path() == 'auth') ){
            return back();
        }
        
        if(!auth()->user() && ($request->path() !='auth' && $request->path() !='/')){
            return redirect('auth')->with('fail','You must be logged in');
        }
        return $next($request)->header('Cache-Control','no-cache, no-store, max-age=0, must-revalidate')
                              ->header('Pragma','no-cache')
                              ->header('Expires','Sat 01 Jan 1990 00:00:00 GMT');
    }
}
