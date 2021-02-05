<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Tenant\Keywords;

class KeywordsController extends Controller
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
     * @param  \App\Keywords  $keywords
     * @return \Illuminate\Http\Response
     */
    public function show(Keywords $keywords)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Keywords  $keywords
     * @return \Illuminate\Http\Response
     */
    public function edit(Keywords $keywords)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Keywords  $keywords
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Keywords $keywords)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Keywords  $keywords
     * @return \Illuminate\Http\Response
     */
    public function destroy(Keywords $keywords)
    {
        //
    }

    public function getSubjects()
    {
        // get all the subject from the keywords
        $getAllSubjects = Keywords::where('filter','Subjects')->get();

        return response([
            'subjects' => $getAllSubjects,
            'status' => 'ok',
        ], 200);
    }

}
