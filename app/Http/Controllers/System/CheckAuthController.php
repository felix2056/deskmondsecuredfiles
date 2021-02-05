<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\System\User;

class CheckAuthController extends Controller
{
    public function __invoke ()
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
  }
}
