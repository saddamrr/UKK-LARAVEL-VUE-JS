<?php

namespace App\Http\Middleware;

use App\Helpers\ResponHelper;
use Closure;
use Illuminate\Http\Request;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public $response;
    public function __construct(){
        $this->response = new ResponHelper();
    }
    public function handle(Request $request, Closure $next, ...$roles)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

        } catch(Exception $e){
            if($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return $this->response->errorResponse('Token Invalid');
            }
            else if($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return $this->response->errorResponse('Token Expired');
            } else {
                return $this->response->errorResponse('Authorization token not found');
            }
        }

        //If user was authenticated successfully and user is in one of the acceptable roles, send to next request.
        if ($user && in_array($user->level, $roles)) {
            return $next($request);
        }

        return $this->response->errorResponse('You are unauthorize user');
    }
}
