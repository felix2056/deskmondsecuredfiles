<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Tenant\User;


class StudentLoginController extends Controller
{
    public function __invoke (Request $request)
    {
      $rules = [
        'email' => 'required|email',
        'password' => 'required',
        'remember' => 'required'
      ];
  
      $input = $request->only([
        'email', 'password', 'remember'
      ]);

      $validator = Validator::make($input, $rules);

      if ($validator->fails()) {
        return response()->json([
          'errors' => $validator->errors()
        ]);
      }

      $valid = $validator->valid();
      $attempt = Auth::guard('tenant')->attempt(['email' => $valid['email'], 'password' => $valid['password']], $valid['remember']);
      $user = Auth::guard('tenant')->user();

      if ($attempt && $user->role->home == 'student') {
        $hostname  = app(\Hyn\Tenancy\Environment::class)->hostname();
        $cookie = cookie('grant', $user->remember_token, time() + (86400 * 30), '/', $hostname->fqdn, false, true);

        return response()->json([
          'redirect' => $user->role->home,
          // 'fqdn' => $hostname->fqdn,
          'user' => $user->role
        ], 200)->cookie($cookie);
      } else {
        if ($user) {
          $user->update(['remember_token' => null]);
        }
        return response()->json(['error' => 'Invalid email &/or password.'], 200);
      }
    }
}
