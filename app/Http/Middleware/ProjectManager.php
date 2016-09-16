<?php

namespace App\Http\Middleware;

use Closure;

class ProjectManager
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
        if (\Auth::user()->role_id != '1') {
            $request->session()->flash('message', 'You are not authorized!.');
            $request->session()->flash('alert-class', 'alert-danger');
            switch (\Auth::user()->role_id) {
                 case '5':
                    return redirect('/analist');
                    break;
                case '2':
                    return redirect('/riskmanager');
                    break;
                case '4':
                    return redirect('/admin');
                    break;
                case '3':
                    return redirect('/portmanager');
                    break;
                default:
                    return redirect('/');
                    break;
            }
        }
        return $next($request);
    }
}
