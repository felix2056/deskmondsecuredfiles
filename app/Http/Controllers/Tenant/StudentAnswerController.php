<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Tenant\User;
use App\Models\Tenant\Teacher;
use App\Models\Tenant\StudentAnswer;

class StudentAnswerController extends Controller
{
    public function getAnswersByClass(Request $request)
    {
        //this method extracts all answers based on class
        try{                          
            $user = User::find(Auth::guard('tenant')->user()->id);
            $teacher = $user->role;

            if($teacher) {
                $ans = StudentAnswer::with('student:id,firstName,lastName')
                    ->where('class_id', $request->class_id)
                    ->where('teacher_id', $teacher->id)
                    ->get();

                $status = 'ok';
                $message='Answers found!';
                $errCode = 200;
            } else {
                $ans = (object)[];
                $status = 'error';
                $message = 'Teacher info was not found!';
                $errCode = 201;
            }

            return response()->json([
                'answers' => $ans,
                'status' => $status,
                'message' => $message
            ], $errCode);
    
        } catch (ModelNotFoundException $ex) { // User not found
            abort(422, 'Invalid email: administrator not found');
        } catch (Exception $ex) { // Anything that went wrong
            abort(500, 'Could not create record or assign it to administrator');
            // return response([
            //     'message'=> 'an internal error has occurred',
            // ], 500);
        }

    }

    public function setFeedback(Request $request)
    {
        //this method will find the record and update it accordingly.

        $feeds = $request->all();
        foreach($feeds as $rs){
            $feedback = StudentAnswer::find($rs['id']);
            $feedback->update($rs);
        }

        return response()->json([
            'status'=>'ok'
        ],200);
    }
}
