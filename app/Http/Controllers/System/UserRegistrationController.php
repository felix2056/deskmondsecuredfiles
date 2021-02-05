<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\System\User;

class UserRegistrationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
      // Validate request data
      $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users',
        'password' => 'bail|required|min:3',
        'confirm_password' => 'required|min:3'
      ];

      $validator = Validator::make($request->all(), $rules);
      if ($validator->fails()) {
        return response()->json([
          'validator' => $validator->errors()
        ], 200);
      }

      $valid = $validator->valid();

      if ($valid['password'] == $valid['confirm_password'])
      {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
          'success' => 'success'
        ], 200);

      } else {
        return response()->json([
          'error' => 'Passwords do not match'
        ], 200);
      }
    }
}
