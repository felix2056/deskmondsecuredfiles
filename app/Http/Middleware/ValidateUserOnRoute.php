<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use App\Models\System\User;
use Illuminate\Contracts\Auth\Authenticatable;

class ValidateUserOnRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $cookie = Cookie::get('grant');

        $user = User::where('remember_token', $cookie)->first();
        $path = $request->path();
        $admin = '/^admin/i';

        // token found on the cookie
        if ($user != null && $cookie != null) {
            // trying to access non-admin route (e.g. login or register)
            if (preg_match($admin, $path) == false) {
              return redirect('/admin');
            }
            // if any admin routes, let it proceed
            return $next($request);
        }
        
        // no token found
        // trying to access admin routes
        if (preg_match($admin, $path)) {
          // redirect to login
          return redirect('/');
        }
        // non-admin routes, let it proceed
        return $next($request);
    }
}
