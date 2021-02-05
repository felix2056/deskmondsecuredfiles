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
use App\Models\Tenant\liveStream;
use App\Models\Tenant\Keywords;
// use App\liveStream;

use App\Models\Tenant\Student;
use App\Models\Tenant\StudentAnswer;
use App\Models\Tenant\StudentClasses;

class StudentController extends Controller
{
    public function create(Request $request)
    {
      $rules = [
        'firstName' => 'required',
        'lastName' => 'required',
        'email' => 'required',
        'gender' => 'required'
      ];
  
      $validator = Validator::make($request->all(), $rules);
      
      if ($validator->fails()) {
        return response()->json([
          'errors' => $validator->errors() 
        ]);
      }
  
      $valid = $validator->valid();

      $studentExists = Student::where('email', $valid['email'])->first();
      $userExists = User::where('email', $valid['email'])->first();

      if($studentExists) {
        return response()->json([
          'error' => 'A student with this email already exists!'
        ]);
      }

      if($userExists) {
        return response()->json([
          'error' => 'A user with this email already exists!'
        ]);
      }

      $fullname = $valid['firstName'] . ' ' . $valid['lastName'];
      $password = rand(000000, 999999);

      $user = new User;
      $user->name = $fullname;
      $user->email = $valid['email'];
      $user->password = Hash::make($password);
      $user->save();

      $student = new Student();
      $student->firstName = $valid['firstName'];
      
      if ($request->middleName != null) {
        $student->middleName = $request->middleName;
      }

      $student->lastName = $valid['lastName'];
      $student->email = $valid['email'];

      if ($request->dateOfBirth != null) {
        $student->dateOfBirth = $request->dateOfBirth;
      }

      $student->gender = $valid['gender'];
      $student->user_id = $user->id;
      $student->save();

      if (!$user || !$student) {
        return response()->json(['error' => 'Couldn\'t create student!' ]);
      }

      $user->update([
          'role_id' => $student->id,
          'role_type' => 'App\Models\Tenant\Student'
        ]);

      $auth = User::find(Auth::guard('tenant')->user()->id);

      $assignedClass = null;

      // Find class by ID
        $class_id = $request->get('class_id');
        $class = Classes::find($class_id);

        if ($class) {
          // Add Student To Class
          $class->students()->attach($student->id);

          $assignedClass = $class->title;
        }
      

      $hostname  = app(\Hyn\Tenancy\Environment::class)->hostname();
      
      $school = Schools::where('fqdn', $hostname->fqdn)->first();
      $url = $hostname->fqdn . '/login';
      
      Mail::send('emails.sendStudentInvite', array(
          'name' => $fullname,
          'email' => $student->email,
          'password' => $password,
          'auth' => $auth->name,
          'school' => $school->name,
          'class' => $assignedClass,
          'url' => $url
        ), function($message) use ($student, $fullname, $school) {
          $message->from('webmaster@deskmond.com');
          $message->to($student->email, $fullname)->subject('You Have Been Added To '. $school->name);
        });

      return response()->json(['success' => 'Successfully added new student' ], 200);
    }
    
    public function update(Request $request, Student $student)
    {
      $rules = [
        'id' => 'required',
        'firstName' => 'required',
        'lastName' => 'required',
        'gender' => 'required'
      ];
  
      $validator = Validator::make($request->all(), $rules);
      
      if ($validator->fails()) {
        return response()->json([
          'errors' => $validator->errors() 
        ]);
      }
  
      $valid = $validator->valid();

      $student = Student::find($valid['id']);

      if(!$student) {
        return response()->json([
          'error' => 'This student does not exist!'
        ]);
      }

      $student->firstName = $valid['firstName'];
      
      if ($request->middleName != null) {
        $student->middleName = $request->middleName;
      }

      $student->lastName = $valid['lastName'];

      if ($request->dateOfBirth != null) {
        $student->dateOfBirth = $request->dateOfBirth;
      }

      $student->gender = $valid['gender'];

      // Optional Data
      $student->fatherFirstName = $request->fatherFirstName;
      $student->motherFirstName = $request->motherFirstName;
      $student->familyLastName = $request->familyLastName;
      $student->fatherPhoneNo = $request->fatherPhoneNo;
      $student->motherPhoneNo = $request->motherPhoneNo;
      $student->fatherEmail = $request->fatherEmail;
      $student->motherEmail = $request->motherEmail;
      $student->homePhoneNo = $request->homePhoneNo;
      $student->save();

      if (!$student) {
        return response()->json(['error' => 'Couldn\'t update student details. Try again later!' ]);
      }

      return response()->json(['success' => 'Successfully updated ' . $student->fullname . "'s details" ], 200);
    }

    public function getStudentProfile()
    {
        $user = User::find(Auth::guard('tenant')->user()->id);
        $student = Student::find($user->role->id);
        $student->tracker='';

        return response()->json([
            'student' => $student,
            'status' => 'ok',
        ], 200);
    }

    public function getBrowseClasses()
    {
      //this method will extract the student classes based on the login
      $user = User::find(Auth::guard('tenant')->user()->id);

      $student = Student::find($user->role->id);
      $student->tracker='';

      // $classes = StudentClasses::with('getClass')->where('student_id', $student->id)->get();
      $classes = Classes::with('subject')->orderby('title', 'DESC')->get();

      return response()->json([
          'student' => $student,
          'classes' => $classes,
      ], 200);
    }

    public function getStudentClasses(Request $request)
    {
        //this method will extract the student classes based on the login
        $user = User::find(Auth::guard('tenant')->user()->id);

        $student = Student::find($user->role->id);
        $student->tracker='';

        // $classes = StudentClasses::with('getClass')->where('student_id', $student->id)->get();
        $classes = $student->classes()->with('subject')->get();

        return response()->json([
            'student' => $student,
            'classes' => $classes,
        ], 200);

    }

    public function getStudentClassByID(Request $request)
    {
      $user = User::find(Auth::guard('tenant')->user()->id);
      $student = Student::find($user->role->id);
      $student->tracker='';

      //this method retrieves a single class based on the passed id
      $class = $student->classes()->with('teacher')->find($request->classID);

      if (!$class) {
          return response()->json([
              'status' => 'error',
              'message' => '404 Not Found: This class does not exist! Redirecting back...'
          ], 404);
      }

      // extract any files that were attached to this?
      $allMedia = $class->getMedia('classimages');
      $allDocs = $class->getMedia('classdocs');
      
      // $teacher = Teacher::find($classex->teacher_id);
      // $classex->teacherAvatar = $teacher->avatar;

      $images = [];
      
      foreach($allMedia as $index => $am){
          $images[$index] = [
              'imageURL' => $am->getFullUrl(),
              'name' => $am->name,
              'size' => $am->human_readable_size,
              'extension' => $am->getCustomProperty('extension')
          ];
      }
      
      $docs = [];
      
      foreach($allDocs as $index => $ad){
          $docs[$index] = [
              'docURL' => $ad->getFullUrl(),
              'name' => $ad->name,
              'size' => $ad->human_readable_size,
              'extension' => $ad->getCustomProperty('extension')
          ];
      }

      return response([
          'classDet' => $class,
          'allMedia' => $images,
          'allDocs' => $docs,
          'status' => 'ok',
      ], 200);
    }

    public function getLiveStreams(Request $request)
    {
        //this method will extract all livestreams with status of on-going
        $user = User::find(Auth::guard('tenant')->user()->id);

        $streams = liveStream::with('subject')->where('status','On-going Live')->where('startDate', '>', today())->get();
        $streamtoday = liveStream::with('subject')->where('startDate',today())->where('status', '<>', 'On-going Live')->where('status', '<>', 'Deleted')->get();

        return response()->json([
            'liveNow'=> $streams,
            'schedToday'=> $streamtoday,
        ], 200);
    }

    public function setStudentAnswer(Request $request)
    {
        //this method will create/upload new asnwers for the student;
        $user = Auth::user();
        $student = Student::where('user_id',$user->id)->first();

        $ans = StudentAnswer::where('student_id',$student->id)->where('class_id',$request->class_id)->first();

        if(!$ans){
            $ans = StudentAnswer::create($request->all());
        }else{
            $ans->update($request->all());
        }

        if($request->has('file')){
            $ans
                ->addMediaFromRequest('file')
                ->toMediaCollection('answers');
        }

        $media = $ans->getMedia('answers');

        return response()->json([
            'answer'=>$ans,
            'media'=>$media,
            'status'=>'ok'
        ],200);
    }

    public function getStudentAnswer(Request $request)
    {
        //this method will create/upload new asnwers for the student;
        $user = Auth::user();
        $student = Student::where('user_id',$user->id)->first();

        $ans = StudentAnswer::where('student_id',$student->id)->where('class_id',$request->class_id)->first();

        if(!$ans){
            $media = '';
            $ans = (object)[];
        }else{
            $media = $ans->getMedia('answers');
        }

        return response()->json([
            'answer' => $ans,
            'media' => $media,
            'status'=>'ok',
        ], 200);
    }

    public function getAnswrByID(Request $request)
    {
        //this method allows retrieval of records specfic to  aide
        $user = User::find(Auth::guard('tenant')->user()->id);

        $ans = StudentAnswer::find($request->answer_id);

        if($ans){
            $media = $ans->getMedia('answers');
            $status = 'ok';
        }else{
            $media = '';
            $ans = (object)[];
            $status = 'error';
        }

        return response()->json([
            'answer' => $ans,
            'media' => $media,
            'status' => $status
        ],200);

    }

    public function getAnswList()
    {
        //this method just gets the list of the current user
        $user = User::find(Auth::guard('tenant')->user()->id);
        $student = Student::find($user->role->id);

        $anslist = StudentAnswer::with(['classx:id,title','subject:id,title'])->where('student_id', $student->id)->get();
        $subjects = Keywords::where('filter','Subjects')->get();

        return response()->json([
            'answer' => $anslist,
            'subjects' => $subjects,
            'status' => 'ok',
        ], 200);

    }

}
