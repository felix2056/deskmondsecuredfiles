<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Models\Tenant\Teacher;
use App\Models\Tenant\User;
use App\Models\System\Schools;
use App\Models\Tenant\Classes;

class TeacherController extends Controller
{
    public function create(Request $request)
    {
      $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:users|unique:teachers'
      ];
  
      $validator = Validator::make($request->all(), $rules);
      
      if ($validator->fails()) {
        return response()->json([
          'errors' => $validator->errors() 
        ]);
      }
  
      $valid = $validator->valid();

      $teacherExists = Teacher::where('email', $valid['email'])->first();
      $userExists = User::where('email', $valid['email'])->first();

      if($teacherExists) {
        return response()->json([
          'error' => 'A teacher with this email already exists!'
        ]);
      }

      if($userExists) {
        return response()->json([
          'error' => 'A user with this email already exists!'
        ]);
      }

      $password = Str::random(20);

      $user = new User;
      $user->name = $valid['name'];
      $user->email = $valid['email'];
      $user->password = Hash::make($password);
      $user->save();

      $teacher = new Teacher();
      $teacher->name = $valid['name'];
      $teacher->email = $valid['email'];
      $teacher->user_id = $user->id;
      $teacher->save();

      if (!$user || !$teacher) {
        return response()->json(['error' => 'Couldn\'t create teacher!' ]);
      }

      $user->update([
        'role_id' => $teacher->id,
        'role_type' => 'App\Models\Tenant\Teacher'
      ]);

      $auth = User::find(Auth::guard('tenant')->user()->id);

      $assignedClass = null;

      // Check if class_id is not null and attempt to assiociate a class to a teacher
      if ($request->has('class_id') && $request->get('class_id') != null) {
        // Find class by ID
        $class_id = $request->get('class_id');
        $class = Classes::find($class_id);

        if ($class) {
          // Assign Teacher To Class
          $class->teacher_id = $teacher->id;
          $class->save();

          $assignedClass = $class->title;
        }
      }

      $hostname  = app(\Hyn\Tenancy\Environment::class)->hostname();
      
      $school = Schools::where('fqdn', $hostname->fqdn)->first();
      $url = $hostname->fqdn . '/teacher-login';
      
      Mail::send('emails.sendTeacherInvite', array(
          'name' => $teacher->name,
          'email' => $teacher->email,
          'password' => $password,
          'auth' => $auth->name,
          'school' => $school->name,
          'class' => $assignedClass,
          'url' => $url
        ), function($message) use ($teacher, $school) {
          $message->from('webmaster@deskmond.com');
          $message->to($teacher->email, $teacher->name)->subject('You Have Been Invited To Join '. $school->name);
        });

      return response()->json(['success' => 'Successfully added new teacher' ], 200);
    }
}
