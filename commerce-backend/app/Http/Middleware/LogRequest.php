<?php

namespace App\Http\Middleware;

use App\Models\Log;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogRequest
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        $userLoggedIn = Auth::user();

        Log::create([
            'status_code' => $response->status(),
            'method' => $request->method(),
            'endpoint' => $request->path(),
            'response_time' => microtime(true) - LARAVEL_START,
            'user_id' => $userLoggedIn->user_id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return $response;
    }
}
