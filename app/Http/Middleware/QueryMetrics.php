<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QueryMetrics
{
    public function handle($request, Closure $next)
    {
        // Tylko w środowisku deweloperskim
        if (app()->environment('local')) {
            DB::enableQueryLog();
        }
        
        $response = $next($request);
        
        if (app()->environment('local')) {
            $queries = DB::getQueryLog();
            $queryCount = count($queries);
            $slowQueries = collect($queries)->filter(function ($query) {
                return $query['time'] > 100; // Powyżej 100ms
            });
            
            if ($slowQueries->count() > 0) {
                Log::channel('daily')->info('Slow queries detected', [
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'total_queries' => $queryCount,
                    'slow_queries' => $slowQueries->toArray()
                ]);
            }
        }
        
        return $response;
    }
}