<?php

namespace Modules\Http;

use Closure;

class JsonAPI
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->isJson() && $request->ajax()) {
            return $next($request);
        }

        //Se manda el mensaje según estandar
        return response()->json(['error' => 'Method not allowed'], 405);
    }
}
