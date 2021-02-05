<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use App\Models\Tenant\Classes;
use App\Models\Tenant\Teacher;

class MediaController extends Controller
{
    protected $client;
    protected $youtube;

    public function getYouTubeInfo(Request $request)
    {
        //retrieve the info
        //this method pulls info from youtube videos
        //it cant be run on the client because of CORS
        
        $this->client = new \Google_Client();

        $this->client->setClientId(env('YOUTUBE_CLIENT_ID', '239953295990-1tmlpvuv6mos951idr6mahrsqo53d93k.apps.googleusercontent.com'));
        $this->client->setClientSecret(env('YOUTUBE_SECRET', 'xfBQ_vppfN83Bxxv_WqUADvJ'));
        $this->client->refreshToken(env('YOUTUBE_REFRESH_TOKEN', '1//048Got7trjI3UCgYIARAAGAQSNwF-L9IrT_DisRwvkz73pwT-2sF9z2dc5JRSu3egzP1ie33q4ISEqzrbmTY2uCtoCiomvvOwEOo'));
        $this->client->setAccessType('offline');
        $this->client->setApprovalPrompt('force');

        $this->youtube = new \Google_Service_YouTube($this->client);

        $video_id = $request->videoID;

        $queryParams = [
    		'id' => $video_id
		];

        $response = $this->youtube->videos->listVideos('id,snippet,statistics', $queryParams);

        if ($response) {
            return response()->json($response, 200);
        }

        return response()->json('Video Not Found!', 404);
    }

    public function fileUpload(Request $request)
    {
        $classes = Classes::find($request->id);

        if($request->has('file')){
            // Upload file to the tenant's own storage directory
            $file = $request->file('file');

            //return response($file, 418);

            $extension = $file->getClientOriginalExtension();

            $classes
                ->addMedia($file)
                ->withCustomProperties(['extension' => $extension])
                ->toMediaCollection('classimages');
            
        }
        
        return response([
            'fileURL' => $classes->getFirstMediaURL('classimages'),
            'status' => "ok",
        ], 200);
    }

    public function filePondUpload(Request $request)
    {
        $classes = Classes::find($request->id);

        if($request->has('file')){
            $classes 
                ->addMediaFromRequest('file')
                ->toMediaCollection('classimages');
        }
        $allMedia = $classes->getMedia();
        $filePath = '/files/nowistime/'.today();
        
        return Response::make($this->getServerIdFromPath($filePath), 200, [
            'Content-Type' => 'text/plain',
        ]);
    }

    public function getServerIdFromPath($path)
    {
        return Crypt::encryptString($path);
    }

    public function docsUpload(Request $request)
    {
        //this method is used to upload documents into the media server
        $classes = Classes::find($request->id);
        
        if($request->has('file')) {
            // Upload file to the tenant's own storage directory
            $file = $request->file;
            $extension = $file->getClientOriginalExtension();

            $classes
                ->addMedia($file)
                ->withCustomProperties(['extension' => $extension])
                ->toMediaCollection('classdocs');
        }

        return response([
            'fileURL'=>env('APP_URL').$classes->getFirstMediaURL('classdocs'),
            'status'=>'ok'
        ], 200);
    }

    public function getFiles(Request $request)
    {
        $classes = Classes::find($request->id);

        $allMedia = $classes->getMedia('classimages');
        $allDocs = $classes->getMedia('classdocs');

        $images = [];

        forEach($allMedia as $index => $am){
            $images[$index] = [
                'imageURL' => $am->getFullUrl(),
                'name' => $am->name,
                'size' => $am->human_readable_size,
                'extension' => $am->getCustomProperty('extension')
            ];
        }

        $docs = [];
        
        forEach($allDocs as $index => $ad){
            $docs[$index] = [
                'docURL' => $ad->getFullUrl(),
                'name' => $ad->name,
                'size' => $ad->human_readable_size,
                'extension' => $ad->getCustomProperty('extension')
            ];
        }

        return response([
            'allMedia' => $images,
            'allDocs' => $docs,
            'status'=> 'ok'
        ], 200);
    }

    public function delFiles(Request $request)
    {   
        //this method will delete a group of men 
        //the request will receive details of the file to be deleted from media collection

        $cl = Classes::find($request->class_id);

        if($cl){
            //found it
            $allMedia = $cl->getMedia('classimages');
            $allDocs = $cl->getMedia('classdocs');

            $collection = $allMedia->concat($allDocs);
            $allCl = collect($collection);

            foreach($allCl as $c){
                if($c->name == $request->fileName){
                    $c->delete();
                }
            }
            
            return response([
                'status' => 'Ok',
                'message' => 'File deleted sucessfully'
            ],200);
        }else{
            return response([
                'status' => 'error',
                'message' => 'class was not found'
            ], 401);
        }

    }

    public function uploadTeacherAvatar(Request $request)
    {
        $messages = [
            'avatar.max' => 'The :attribute size must be under 2MB',
        ];
      
        $rules = [
            'avatar' => 'mimes:jpeg,jpg,png,gif|max:2048',
        ];
      
        $validator = Validator::make($request->all(), $rules, $messages);
      
        if ($validator->fails()) {
            return response()->json([
              'error' => $validator->errors()
            ], 401);
        }

        $teacher = Teacher::find($request->teacher_id);

        if (!$teacher) {
            return response()->json([
                'error' => 'This teacher does not exists!'
            ], 401);
        }

        $hostname = app(\Hyn\Tenancy\Environment::class)->hostname();

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
      
            if ($teacher->avatar !== null) {
              $avatar_exists = Storage::disk('tenancy')->exists("tenants/{$hostname->fqdn}/avatars/" . $teacher->avatar);
      
              if ($avatar_exists) {
                Storage::disk('tenancy')->delete("tenants/{$hostname->fqdn}/avatars/" . $teacher->avatar);
              }
            }
      
            $avatarname = time() . '_' . $avatar->getClientOriginalName();;
            $path = $avatar->storeAs("tenants/{$hostname->fqdn}/avatars/", $avatarname, 'tenancy');
      
            if ($path) {
              $teacher->avatar = $avatarname;
              $teacher->save();
            }

            return response()->json([
                'success' => 'Avatar Uploaded'
            ]);
          }
          
    }
}
