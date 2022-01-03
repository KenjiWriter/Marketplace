<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Cache;
use Carbon\Carbon;

use App\Models\user;

class lastUserActivity
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
        if(auth::check()) {
            $expiresAt = now()->addMinutes(5);
            Cache::put('user-is-online-'. auth()->user()->id,true,$expiresAt);

            user::where('id', auth()->user()->id)->update(['last_seen' => now()]);
        }
        return $next($request);
    }
}
