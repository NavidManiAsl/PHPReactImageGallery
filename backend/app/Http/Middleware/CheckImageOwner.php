<?php

namespace App\Http\Middleware;

use App\Models\Image;
use App\Traits\HttpResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckImageOwner
{
    use HttpResponse;
    /**
     * Handle an incoming request and check if the user is authorized.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        $uri = explode('/',$request->getRequestUri());
        end($uri);
        
       $imageId = end($uri);
        $image = Image::find($imageId);
        if (!$image){
            return $this->error('null', 'Not found', 404);
        }
        
        $user = auth('sanctum')->user();

        if (!$user) {
            return $this->error('null', 'Unauthenticated',401);
        }
        
        
        if (
            $user->id !== $image->user_id
        ) {
            return $this->error(null, 'Unauthorized', 401);
        }


        return $next($request );
    }
}
