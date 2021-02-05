<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\Tenant\User;
use Illuminate\Support\Facades\Auth;

class CheckAuthController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */

    public function __invoke(Request $request)
    {
      $isLoggedIn = Auth::guard('tenant')->check();
      
      if(!$isLoggedIn) {
        return response()->json([
          'state' => false
        ], 200);
      }

      $user = User::find(Auth::guard('tenant')->user()->id);

      if ($user == null) {
        return response()->json([
          'state' => false
        ], 200);
      }

      return response()->json([
        'state' => true
      ], 200);
    }


    /*public function __invoke(Request $request)
    {
      $cookie = Cookie::get('grant');
      if ($cookie == null) {
        return response()->json([
          'state' => false
        ], 200);
      }

      $user = User::where('remember_token', $cookie)->first();
      if ($user == null) {
        return response()->json([
          'state' => false
        ], 200);
      }

      return response()->json([
        'state' => true
      ], 200);

    }*/
}
