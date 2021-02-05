<?php

namespace App\Http\Middleware;

use App\Helper\Helper;
use Illuminate\Support\Facades\Cookie;
use App\Models\Tenant\User;
use Illuminate\Support\Facades\Auth;

use Closure;

class ValidateTenantUserOnRoute
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
        $path = $request->path();

        if (!Auth::guard('tenant')->check()) {
            //Tenant not logged in, check for cookie

            // Remember that the app is on Vue. So a complementary implementation
            // of route guards on vue-router is needed.
            // Check if user token was saved on the browser
            $cookie = Cookie::get('grant');
            $user = User::where('remember_token', $cookie)->first();
            
            if ($user != null && $cookie != null) {
                Auth::guard('tenant')->login($user);

                // trying to get to login or register
                if ($path == 'login' || $path == 'register' || $path == 'teacher') {
                    if ($user->role->home == 'teacher') {
                        return redirect("{$user->role->home}"."/home");
                    } else if ($user->role->home == 'admin') {
                        return redirect('/admin');
                    } else {
                        return redirect("{$user->role->home}");
                    }
                }

                // trying to access a url not for his role
                if (preg_match("/^{$user->role->home}/i", $path) == false) {
                    if ($user->role->home == 'teacher') {
                        return redirect("{$user->role->home}"."/home");
                    } else if ($user->role->home == 'admin') {
                        return redirect('/admin');
                    } else {
                        return redirect("{$user->role->home}");
                    }
                } 
            }

            elseif (Helper::isRoute(['teacher*']) || Helper::isRoute(['student*'])) {
                if (Helper::isRoute(['teacher*'])) {
                    return redirect('/teacher-login');
                }
                
                // if (Helper::isRoute(['student*'])) {
                //     return redirect('/student-login');
                // } 

                return redirect('/login');
            }

            elseif (Helper::isRoute(['admin*'])) {
                return redirect('/admin-login');
            }
            
            else {
                return $next($request);
            }          
        }

        $user = Auth::guard('tenant')->user();

        // trying to get to login or register while already authenticated
        if ($path == 'login' || $path == 'register' || $path == 'teacher-login' || $path == 'admin-login') {
            if ($user->role->home == 'teacher') {
                return redirect("{$user->role->home}"."/dashboard");
            } else if ($user->role->home == 'admin') {
                return redirect('/admin');
            } else {
                return redirect("{$user->role->home}");
            }
        }

        // trying to access a url not for his role
        if (preg_match("/^{$user->role->home}/i", $path) == false) {
            if ($user->role->home == 'teacher') {
                return redirect("{$user->role->home}"."/home");
            } else if ($user->role->home == 'admin') {
                return redirect('/admin');
            } else {
                return redirect("{$user->role->home}");
            }
        } 
        
        return $next($request);
    }
}
