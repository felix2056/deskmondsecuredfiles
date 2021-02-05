<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Tenant\StudentClasses;

class StudentClassesController extends Controller
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
        return view('student.create');
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
     * @param  \App\StudentClasses  $studentClasses
     * @return \Illuminate\Http\Response
     */
    public function show(StudentClasses $studentClasses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StudentClasses  $studentClasses
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentClasses $studentClasses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StudentClasses  $studentClasses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentClasses $studentClasses)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StudentClasses  $studentClasses
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentClasses $studentClasses)
    {
        //
    }
}
