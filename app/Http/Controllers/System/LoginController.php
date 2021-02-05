<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\System\User;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
      $rules = [
        'email' => 'required|email',
        'password' => 'bail|required|min:3',
        'remember' => 'required'
      ];
      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
        return response()->json([
          'validator' => $validator->errors()
        ], 200);
      }
      $valid = $validator->valid();
      $credentials = array(
        'email' => $valid['email'],
        'password' => $valid['password']
      );
  
      if (Auth::attempt($credentials, $valid['remember'])) {
        $user = Auth::user();
        $cookie = cookie('grant', $user->remember_token, time() + (86400 * 30), '/', env('APP_URL'), false, true, false, 'none');
        return response()->json([
          'message' => 'successfully logged in!',
          'user' => $user
        ], 200)->cookie($cookie);
      } else {
        return response()->json(['error' => 'Invalid email &/or password.'], 200);
      }
  
    }
}
