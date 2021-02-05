<?php

namespace App\Http\Controllers;

use App\liveStream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class LiveStreamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function updateLiveStream(Request $request)
    {
        //this method comes from api to uplad live stream
        $user_id = Auth::user()->id;

        if($request->id > 0){
            //update
            $lstream = liveStream::find($request->id);
            $lstream->update($request->all());

        }else{
            //create a new schedule
            $lstream = liveStream::create($request->all());
            $lstream->teacher_id = $user_id;
            $lstream->room_id = Str::random(30);
            $lstream->room_key = crypt::encryptString(Str::random(10));
            $lstream->save();
        }

        return response([
            'room_id'=>$lstream->room_id,
            'status'=>'ok'
        ],200);
    }   

    public function getstreamtoday(Request $request)
    {
        //method extracts the streams of teh current logged in user
        $user_id = Auth::user()->id;

        $list = liveStream::with('subject')->where('teacher_id',$user_id)->where('startDate','>=',today())->where('status','<>','Deleted')->get();

        return response([
            'streams'=>$list,
            'status'=>'ok',
        ], 200);
    }

    public function delStream(Request $request)
    {
        //method finds the id of the stream based on logged user
        $user_id = Auth::user()->id;
        $find = liveStream::find($request->id);

        if($find){
            //found, change status
            $find->status = 'Deleted';
            $find->save();

            return response([
                'streams'=> liveStream::with('subject')->where('teacher_id',$user_id)->where('startDate','>=',today())->where('status','!=','Deleted')->get(),
                'status'=>'ok'
            ], 200);
        }else{
            //not found, return error;
            return response([
                'streams'=> liveStream::with('subject')->where('teacher_id',$user_id)->where('startDate','>=',today())->where('status','!=','Deleted')->get(),
                'status'=>'error',
                'message'=>'ID was not found!'
            ], 200);
        }
    }

    public function getRoom(Request $request)
    {
        //this method is used to get the room key

        //put validation here if this requestor is able to extract this key
        // check currently logged in teacher is linked to this schedue

        $sched = liveStream::find($request->ConfID);
        if($sched){
            return response([
                'key'=>Crypt::decryptString($sched->room_key),
                'room_id'=>$sched->room_id,
                'status'=>'ok',
            ], 200);
        }else{
            return response([
                'key'=>'',
                'room_id'=>'',
                'status'=>'invalid app_key',
            ], 401);
        }
    }

    public function setLiveStream(Request $request)
    {
        //this method sets the live stream
        $ls = liveStream::find($request->ConfID);

        if($ls){
            $ls->status = $request->status;
            $ls->save();

            return response([
                'key'=>Crypt::decryptString($ls->room_key),
                'status'=>'ok'
            ], 200);
        }

        return response([
            'key'=>'',
            'status'=>'Conference ID was not found or Invalid',
        ], 401);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\liveStream  $liveStream
     * @return \Illuminate\Http\Response
     */
    public function show(liveStream $liveStream)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\liveStream  $liveStream
     * @return \Illuminate\Http\Response
     */
    public function edit(liveStream $liveStream)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\liveStream  $liveStream
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, liveStream $liveStream)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\liveStream  $liveStream
     * @return \Illuminate\Http\Response
     */
    public function destroy(liveStream $liveStream)
    {
        //
    }
}
