<?php

namespace App\Http\Controllers;

use App\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->pageSet = [
            'pagename'=>'Teachers',
            'menuTag'=>'Teachers',
            'menuHead'=>'',
            'actionHed'=>'teachers',
            'actionTyp'=>'List',
            'actionID'=>0
        ];

        // $this->middleware('permission:admin-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:admin-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:admin-show', ['only' => ['index']]);
        // $this->middleware('permission:admin-delete', ['only' => ['destroy']]);
        // $this->roles = Role::all();
        // $this->middleware('auth');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tr = Teacher::all();

        return view('teacher.index',['teachers'=>$tr,'ps'=>$this->pageSet]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teacher.create',['ps'=>$this->pageSet]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email'=>'required',
            'dateOfBirth'=>'required',
        ]);

        //check to see if the email exist on users
        $user = User::where('email',$request->email)->first();
        
        if(!$user){
            //does not exist, create
            $dob = date_create($request->dateOfBirth);
            $dft = date_format($dob,"DDMMYY");
            $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            $pass = $dft.$random_number;

            $user = User::create([
                'name'=>$request->firstName.' '.$request->lastName,
                'email'=>$request->email,
                'password'=>bcrypt($pass),
            ]);

            activity('Create Teacher User')->log('A new Teacher '.$request->email.' with pass '.$pass.' was created');
        }

        //create the teacher info
        $tr = Teacher::create($request->all());
        $tr->user_id = $user->id;
        $tr->save();

        activity('Create Teacher info')->log('A Teacher record is created '.$request->email);

        return redirect()->route('teachers.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        return view('teacher.edit',['teacher'=>$teacher,'ps'=>$this->pageSet]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'email'=>'required',
            'dateOfBirth'=>'required',
        ]);

        //check to see if the email exist on users
        $user = User::where('email',$request->email)->first();
        
        if(!$user){
            //does not exist, create
            $dob = date_create($request->dateOfBirth);
            $dft = date_format($dob,"DDMMYY");
            $random_number = intval( "0" . rand(1,9) . rand(0,9) . rand(0,9) . rand(0,9) . rand(0,9) );
            $pass = $dft.$random_number;

            $user = User::create([
                'name'=>$request->firstName.' '.$request->lastName,
                'email'=>$request->email,
                'password'=>bcrypt($pass),
            ]);

            activity('Create Teacher User')->log('A new Teacher '.$request->email.' with pass '.$pass.' was created');
        }

        //create the teacher info
        $teacher->update($request->all());
        $teacher->user_id = $user->id;
        $teacher->save();
        
        activity('Create Teacher info')->log('A Teacher record is created '.$request->email);

        return redirect()->route('teachers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        //
    }
}
