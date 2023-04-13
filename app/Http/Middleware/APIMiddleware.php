<?php

namespace App\Http\Middleware;

use App;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use App\Http\Responses\APIResponse;
use Illuminate\Http\Request;
use Closure;
use JWTAuth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
class APIMiddleware extends BaseMiddleware
{
    use APIResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
      
        if ($request->headers->get('Authorization') == null )
        {
            return $this->errorResponse(403, "Access denied, No token provided");
        }

        try {
            $this->authenticate($request);
        } catch (UnauthorizedHttpException $e) {
            Log::info($e);
            return $this->errorResponse(403, "Bad Request, Invalid authorization token");
        }
        catch(JWTException $e) {
            Log::info($e);
            return $this->errorResponse(403, "Bad Request, Invalid authorization token");
        }

        $user = JWTAuth::user();


        return $next($request);
    }
}
