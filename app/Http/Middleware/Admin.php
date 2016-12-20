<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

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
        if ( Auth::check() && Auth::user()->isAdmin() ) {
            return $next($request);
        }

        return redirect('backend')->with('error_message', 'Per questa operazione devi essere Amministratore !');

    }
    
}

// per creare admin users

// creata colonna in db users
// creato middleware Admin (QUESTO)
// utenti: 2 livellli: admin con tutti i privilegi e author

// ....

// https://laracasts.com/discuss/channels/laravel/user-admin-authentication