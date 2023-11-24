<?php

namespace App\Http\Middleware;

use App\Models\{Image, Gallery};
use App\Traits\HttpResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckOwnership
{
    use HttpResponse;
    /**
     * This middleware verifies the ownership of images and galleries
     * before granting access to the requested resource.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('sanctum')->user();
      

        if (!$user) {
            return $this->unauthenticated();
        }

        $uri = explode('/', $request->getRequestUri());
        end($uri);

        $id = end($uri);
        $type = $uri[count($uri) - 2];
        
        switch ($type) {
            case 'images':
                try {
                    $object = Image::find($id);
                } catch (\Throwable $th) {
                    Log::error($th->getMessage());
                    return $this->serverError();
                }
                break;
                case 'galleries':
                    try {
                        $object = Gallery::find($id);
                    } catch (\Throwable $th) {
                        Log::error($th->getMessage());
                        return $this->serverError();
                    }
                    break;
                    default:
                return $this->serverError();

        }

        if (!$object) {
            return $this->error('null', 'Not found', 404);
        }

        if (
            $user->id !== $object->user_id
        ) {
            return $this->unauthorized();
        }


        return $next($request);
    }
}
