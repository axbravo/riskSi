<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class RedirectIfAuthenticated
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->check()) {
            switch (\Auth::user()->role_id) {
                case '5':
                    return redirect('/analist');
                    break;
                case '4':
                    return redirect('/admin');
                    break;
                case '3':
                    return redirect('/portmanager');
                    break;
                case '2':
                    return redirect('/riskmanager');
                    break;
                case '1':
                    return redirect('/riskresponsable');
                    break;
                default:
                    return redirect('/');
                    break;
            }
        }

        return $next($request);
    }
}
