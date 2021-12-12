<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\product;

class promotingCheck
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
        $products = product::select('promote','promote_to')->get();
        foreach($products as $product) {
            if($product->promote_to != NULL) {
                $promote_to = now()->lt($product->promote_to);
            } else {
                $promote_to = false;
            }
            if($promote_to == false) {
                $product->promote = 0;
                $product->save();
            }
        }
        return $next($request);
    }
}
