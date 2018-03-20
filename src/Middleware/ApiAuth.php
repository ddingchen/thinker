<?php

namespace Thinker\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;


class ApiAuth
{
    
    public function handle($request, Closure $next)
    {
        $sessKey = $this->getSessKeyFrom($request);

        $user = Cache::get('api-session.' . $sessKey);

        if (!$user) {
            return response('访问未授权', 401);
        }

        $user->login();

        return $next($request);
    }

    protected function getSessKeyFrom($request)
    {
        if ($sessKey = $request->input('sess_key')) {
            return $sessKey;
        }

        if ($sessKey = $request->cookie('sess_key')) {
            return $sessKey;
        }

        if ($sessKey = $request->header('sess_key')) {
            return $sessKey;
        }

        return null;
    }

}
