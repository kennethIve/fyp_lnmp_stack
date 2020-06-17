<?php

namespace App\Http\Middleware;

use Closure;

class RestfulApi
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
        $IncomeAuthKey = $request->header("Authorization");
        $ServerAuthKey = env("API_KEY","No key is No key,dont try to access la!");
        if($ServerAuthKey == $IncomeAuthKey)
            return $next($request);
        
        return array("message"=>$IncomeAuthKey."Unauthenticated.".$ServerAuthKey);
    }
}
