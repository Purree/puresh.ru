<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class CanAny
{
    /**
     * The gate instance.
     *
     * @var Gate
     */
    protected Gate $gate;

    /**
     * Create a new middleware instance.
     *
     * @param Gate $gate
     * @return void
     */
    public function __construct(Gate $gate)
    {
        $this->gate = $gate;
    }


    /**
     * Check if user have all gates
     *
     * @param $request
     * @param Closure $next
     * @param $model
     * @param mixed ...$permissions
     * @return mixed
     */
    public function handle($request, Closure $next, $model, ...$permissions): mixed
    {
        if ($this->gate->any($permissions, $model)) {
            return $next($request); // allow
        }

        return redirect(route('user')); // deny
    }
}
