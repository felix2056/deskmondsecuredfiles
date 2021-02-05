<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Tenant\User;
use App\Models\Tenant\Student;
use App\Models\Tenant\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompositeRegister extends Controller
{
    public function __invoke (Request $request)
    {
      $rules = [
        'role' => 'required',
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required',
        'confirm_password' => 'required'
      ];

      $input = $request->only([
        'role', 'name', 'email', 'password', 'confirm_password'
      ]);

      $validator = Validator::make( $input, $rules);

      if ($validator->fails()) {
        return response()->json([
          'error' => $validator->errors()
        ]);
      }

      $valid = $validator->valid();
      if ($valid['password'] != $valid['confirm_password']) {
        return response()->json([
          'error' => array(
            'password' => 'Passwords do not match',
            'confirm_password' => 'Passwords do not match'
          )
        ]);
      }

      $userExists = User::where('email', $valid['email'])->first();
      if ($userExists) {
        return response()->json([
          'error' => array(
            'email' => 'This email is already taken.'
          )
        ]);
      }

      $user = new User;
      $user->name = $valid['name'];
      $user->email = $valid['email'];
      $user->password = Hash::make($valid['password']);
      $user->save();

      if ($valid['role'] == 'student') {
        $student = new Student;
        $student->user_id = $user->id;
        $student->save();

        $user->update([
          'role_id' => $student->id,
          'role_type' => 'App\Models\Tenant\Student'
        ]);

        return response()->json([
          'message' => 'registered'
        ]);
      }

      if ($valid['role'] == 'teacher') {
        $teacher = new Teacher;
        $teacher->name = $valid['name'];
        $teacher->email = $valid['email'];
        $teacher->user_id = $user->id;
        $teacher->save();

        $user->update([
          'role_id' => $teacher->id,
          'role_type' => 'App\Models\Tenant\Teacher'
        ]);

        return response()->json([
          'message' => 'registered'
        ]);
      }
    }
}
