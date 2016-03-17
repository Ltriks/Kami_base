<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\v1\Account;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission = null)
    {
        //获取用户权限
        if ($user = Account::findBySession($request->header('Authorization'))) {
            if (!$user->can($permission))
            {
                return response()->json([
                    'success' => false,
                    'code' => 401,
                    'message' => trans('message.unauthorized')
                ])->setCallback($request->get('callback'));
            }
        }

        return $next($request);
    }
}
