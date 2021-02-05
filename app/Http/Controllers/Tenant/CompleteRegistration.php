<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\System\Schools;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\System\PendingSchoolRegistration;
use App\Models\Tenant\User;
use App\Models\Tenant\Admin;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

use App\Models\Tenant\Keywords;
use App\Models\Tenant\Setting;
use Carbon\Carbon;

class CompleteRegistration extends Controller
{
    public function init(Request $request)
    {
      $request->validate([
        'password' => 'required',
        'confirm_password' => 'required'
      ]);
      
      if ($request->password == $request->confirm_password)
      {
        $hostname = app(\Hyn\Tenancy\Environment::class)->hostname();
        $school = Schools::where('fqdn', $hostname->fqdn)->firstOrFail();
        $pending = PendingSchoolRegistration::where('school_id', $school->id)->firstOrFail();

        // Register the user as admin on its own database.
        $user = new User;
        $user->name = $pending->name;
        $user->email = $pending->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $school->completed_registration = true;
        $school->save();
        
        $pending->delete();

        $admin = new Admin;
        $admin->super_admin = true;
        $admin->user_id = $user->id;
        $admin->save();

        $user->update([
          'role_id' => $admin->id,
          'role_type' => 'App\Models\Tenant\Admin'
        ]);

        if (count(Keywords::where('filter','Subjects')->get()) == 0) {
          $this->createDefaultSubjects();
        }

        return response()->json([ 'message' => 'successfully registered.' ], 200);
      } else {
        return response()->json([
          'error' => 'passwords do not match.'
        ], 200);
      }
    }

    protected function createDefaultSubjects()
    {
      // Create English
      $english = new Keywords();

      $english->filter = 'Subjects';
      $english->title = 'English';
      $english->description = 'English Language Subject';
      $english->count = 1;
      $english->amount = 100;
      $english->dateTime = Carbon::now();
      $english->save();

      // Create Maths
      $maths = new Keywords();

      $maths->filter = 'Subjects';
      $maths->title = 'Maths';
      $maths->description = 'Mathematics Subject';
      $maths->count = 1;
      $maths->amount = 100;
      $maths->dateTime = Carbon::now();
      $maths->save();

      // Create Science
      $science = new Keywords();

      $science->filter = 'Subjects';
      $science->title = 'Science';
      $science->description = 'Science Subject';
      $science->count = 1;
      $science->amount = 100;
      $science->dateTime = Carbon::now();
      $science->save();

      // Create Settings
      $settings = new Setting();

      $settings->is_fee_paying_school = true;
      $settings->is_primary_school = false;
      $settings->is_let_student_choose_classes = false;
      $settings->save();
    }
}
