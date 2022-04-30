<?php

namespace App\Http\Middleware;

use App\Models\RestrictedIp;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RestrictIpAddress
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (RestrictedIp::where("ip", $request->ip())->get()->isNotEmpty()) {
            abort(403, __("Your ip is blocked"));
        }
        return $next($request);
    }
}
