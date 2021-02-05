<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\Tenant\User;

class CompositeLogout extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
      $cookie = Cookie::get('grant');

      $user = User::where('remember_token', $cookie)->first();
      if ($user == null) {
        return response()->json([
          'error' => 'Theres something wrong with your token.'
        ], 200);
      }

      $user->update(['remember_token' => null]);
      $forget = Cookie::forget('grant');
      return response()->json([
        'message' => 'logged-out'
      ], 200)->cookie($forget);
    }
}
