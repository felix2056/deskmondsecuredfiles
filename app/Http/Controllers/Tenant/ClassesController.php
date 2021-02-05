<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use PDO;

use App\Models\Tenant\User;
use App\Models\Tenant\Teacher;
use App\Models\Tenant\Classes;
use App\Jobs\ChangeClassStatus;

class ClassesController extends Controller
{
    public function getClasses()
    {
        $classes = Classes::all();

        return response()->json([
            'classes' => $classes
        ]);
    }

    public function getClassesByTeacher()
    {
        //this method extracts all classes that belong to the currently logged on teacher

        $user = User::find(Auth::guard('tenant')->user()->id);

        $drafts = Classes::with('subject')
            ->where('teacher_id', $user->role->id)
            ->where('status', 'Draft')
            ->orderBy('startDate', 'DESC')
            ->get();

        $scheduled = Classes::with('subject')
            ->where('teacher_id', $user->role->id)
            ->where('status','Scheduled')
            ->where('startDate', '>=', today())
            ->orderBy('startDate','DESC')
            ->get();

        $active = Classes::with('subject')
            ->where('teacher_id', $user->role->id)
            ->where('status', 'Active')
            ->where('startDate', '>=', today())
            ->orderBy('startDate', 'DESC')
            ->get();

        $inReview = Classes::with('subject')
            ->where('teacher_id', $user->role->id)
            ->where('status', 'In Review')
            ->get();

        $completed = Classes::with('subject')
            ->where('teacher_id', $user->role->id)
            ->where('status','Completed')
            ->where('startDate', '<=', today())
            ->where('submissionDate', '>=', today())
            ->get();

        $marking = Classes::with('subject')
            ->where('teacher_id', $user->role->id)
            ->where('status','Marking')
            ->where('startDate', '<=', today())
            ->where('submissionDate', '<=', today())
            ->get();

        // foreach($scheduled as $index => $sc){
        //     if($sc->marking->count() > 0){
        //         $marking[$index]=$sc;
        //     }
        // }

        return response([
            'classDrafts' => $drafts,
            'classActive' => $active,
            'classScheduled' => $scheduled,
            'classInReview' => $inReview,
            'classCompleted' => $completed,
            'classMarking' => $marking,
            'status' => 'ok',
        ], 200);

    }

    public function getClassByID(Request $request)
    {
        $user = User::find(Auth::guard('tenant')->user()->id);
        
        //this method retrieves a single class based on the passed id
        $classex = Classes::find($request->classID);

        if (!$classex) {
            return response()->json([
                'status' => 'error',
                'message' => '404 Not Found: This class does not exist! Redirecting back...'
            ], 404);
        }

        if ($classex->teacher_id != $user->role->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'This class has not been assigned to you!'
            ], 401);
        }

        // extract any files that were attached to this?
        $allMedia = $classex->getMedia('classimages');
        $allDocs = $classex->getMedia('classdocs');
        
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
            'classDet' => $classex,
            'allMedia' => $images,
            'allDocs' => $docs,
            'status' => 'ok',
        ], 200);
    }

    public function getDrafts()
    {
        $user = User::find(Auth::guard('tenant')->user()->id);

        //it has been prevously saved, therefore retrieve it
        $draft = Classes::where('teacher_id', $user->role->id)
            ->where('status', 'Draft')
            ->latest()
            ->first();

        if($draft && $draft != null) {
            // extract any files that were attached to this?
            $allMedia = $draft->getMedia('classimages');
            $allDocs = $draft->getMedia('classdocs');
            
            // $teacher = Teacher::find($draft->teacher_id);
            // $draft->teacherAvatar = $teacher->avatar;

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

            return response()->json([
                'draft' => $draft,
                'allMedia' => $images,
                'allDocs' => $docs,
                'status' => 'ok',
            ], 200);
            
        }
            
        return response()->json([
            'draft' => null,
            'status' => 'ok',
        ], 200);
        
    }

    public function updateClass(Request $request)
    {
        $data = $request->except('images');

        $user = User::find(Auth::guard('tenant')->user()->id);

        $data['teacher_id'] = $user->role->id;
        
        //this method is called from api  it will determine if the classs posted exist or will be created as draft
        if($data['id'] > 0){
            //it has been prevously saved, therefore retrieve it
            $classex = Classes::find($data['id']);
            $classex->update($data);
        } else {
            //assume the data has not been saved
            $classex = Classes::create($data);
        }

        if($request->has('images')){
            $allImages = $request->file('images');

            foreach ($allImages as $image) {
                // Upload file to the tenant's own storage directory
                $extension = $image->getClientOriginalExtension();

                $classex
                    ->addMedia($image)
                    ->withCustomProperties(['extension' => $extension])
                    ->toMediaCollection('classimages');
            }
            
        }
        
        Log::info('REQUEST CLASS. ' . json_encode($classex));

        // if ($classex->status == "Scheduled") {
        //     $startDate = Carbon::parse($data['startDate']);
            
        //     $now = Carbon::now();
        //     $diff = $startDate->diffInHours($now);
        //     $date = $now;
            
        //     if($diff > 0) {
        //         $diff > 24 ? ($date = $now->addDays(ceil($diff / 24))) : ($date = $now->addDay());
        //     }
            
        //     $job = new ChangeClassStatus($classex);
        //     $job->dispatch($classex)->delay($date);

        //     Log::info('-------------' . $date);
        // }

        return response([
            'classes' => $classex,
            'status' => 'ok',
        ],200);

    }

    public function updateClassStatus(Request $request)
    {
        if($request->class_id > 0){
            //update the status as indicated
            $c = Classes::find($request->class_id);
            $c->status = $request->status;
            $c->save();
        }

        return response()->json([
            'status'=>'ok',
            'messages'=>'task completed'
        ]);


    }

}
