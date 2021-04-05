<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ValidateApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $key = 'x-api-key';
        if (! $token = $request->input($key) ?? ($request->header($key) ?? null)) {
            return response()->json(['message' => 'Api token not found'], 400);
        }    

        $userId = Cache::remember($token, 60 * 60 * 24 * 7, function () use ($token) {
            $user = optional(\App\Models\ApiToken::where('access_token', $token)->first())->user;
            return $user ? $user->id : null;
        });

        if (! $userId) {
            Cache::forget($token);
            return response()->json(['message' => 'Invalid token provided.'], 403);
        }

        $request['userId'] = $userId;
        return $next($request);
    }
}
