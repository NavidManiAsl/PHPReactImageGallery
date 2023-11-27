<?php

namespace App\Http\Middleware;

use App\Traits\HttpResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Auth
{
    use HttpResponse;
    /**
     * Handle an incoming request.Check user authentication status
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
      
        if(!$request->user('sanctum')){
            
            return $this->unauthenticated();

        }
        
        return $next($request);
    }
}
