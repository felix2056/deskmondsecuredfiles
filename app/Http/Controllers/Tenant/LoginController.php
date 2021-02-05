<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Tenant\User;

class LoginController extends Controller
{
  public function __invoke(Request $request)
  {
    $rules = [
      'email' => 'required|email',
      'password' => 'required',
      'remember' => 'required'
    ];

    $validator = Validator::make($request->only('email', 'password', 'remember'), $rules);
    if ($validator->fails()) {
      return response()->json([
        'errors' => $validator->errors() 
      ], 200);
    }

    $valid = $validator->valid();

    $attempt = Auth::guard('tenant')->attempt(['email' => $valid['email'], 'password' => $valid['password']], $valid['remember']);
    $user = Auth::guard('tenant')->user();


    if ($attempt && $user->role->home == 'admin') {
      $hostname  = app(\Hyn\Tenancy\Environment::class)->hostname();
      $cookie = cookie('grant', $user->remember_token, time() + (86400 * 30), '/', $hostname->fqdn, false, true);

      return response()->json([
        'redirect' => $hostname->fqdn,
        'user' => $user->role
      ], 200)->cookie($cookie);

      // return response()->json([
      //   'redirect' => $hostname->fqdn,
      //   'user' => $user->role
      // ], 200)->cookie($cookie);
    } else {
      if ($user) {
        $user->update(['remember_token' => null]);
      }
      return response()->json(['error' => 'Invalid email &/or password.'], 200);
    }
  }
}
