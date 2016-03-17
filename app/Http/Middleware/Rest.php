<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use App\Helper\Token;

class Rest
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
        switch (Token::authorization()) {
            case false:
                return response()->json([
                    'success' => false,
                    'code' => 10001,
                    'message' => trans('message.token.invalid')
                ]);
                break;
            
            case 'token-expired':
                return response()->json([
                    'success' => false,
                    'code' => 10002,
                    'message' => trans('message.token.expired')
                ]);
                break;
        }

        return $next($request);
    }

}
