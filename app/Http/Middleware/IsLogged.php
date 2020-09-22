<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsLogged
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
        if (!session()->exists('user_data')) {
            if($request->ajax()){
                return response(['status'=>-1]);
            }
            return redirect(route('login.index'));
        }

        return $next($request);
    }
}
