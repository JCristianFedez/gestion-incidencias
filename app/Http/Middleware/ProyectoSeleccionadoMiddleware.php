<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProyectoSeleccionadoMiddleware
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

        if(! auth()->check()){// Si no ha iniciado sesion
            return redirect("login");
        }

        if(auth()->user()->selected_project_id == null){
            return redirect("/");
        }
        return $next($request);
    }
}
