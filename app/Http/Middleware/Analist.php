<?php

namespace App\Http\Middleware;

use Closure;

class Analist
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
        if (\Auth::user()->role_id != '5') {
            $request->session()->flash('message', 'No estas autorizado para entrar aqui');
            $request->session()->flash('alert-class', 'alert-danger');
            switch (\Auth::user()->role_id) {
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
