<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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
        if (\Auth::user()->role_id != '4') {
            $request->session()->flash('message', 'No estas autorizado para entrar aqui');
            $request->session()->flash('alert-class', 'alert-danger');
            switch (\Auth::user()->role_id) {
                case '5':
                    return redirect('/analist');
                    break;
                case '3':
                    return redirect('/portmanager');
                    break;
                case '2':
                    return redirect('/riskmanager');
                    break;
                case '1':
                    return redirect('/projectmanager');
                    break;
                default:
                    return redirect('/');
                    break;
            }
        }
        return $next($request);
    }
}
