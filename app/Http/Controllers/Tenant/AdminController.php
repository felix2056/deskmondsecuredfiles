<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Tenant\Teacher;
use App\Models\Tenant\Student;
use App\Models\Tenant\Classes;
use App\Models\Tenant\Setting;

class AdminController extends Controller
{
    public function getSettings()
    {
        $settings = Setting::first();

        return response()->json([
            'settings' => $settings
        ]);
    }

    public function getAdminDet()
    {
        $details = [];

        $details['teachersCount'] = Teacher::count();
        $details['studentsCount'] = Student::count();
        $details['settings'] = Setting::first();

        return response()->json([
            'adminDet' => $details
        ]);
    }

    public function getTeacherDet()
    {
        $teacherDet = Teacher::with(['classes'])->get();
        //$teacherDet = Classes::with(['teacher'])->get();

        return response()->json([
            'teacherDet' => $teacherDet
        ]);
    }

    public function getStudentDet()
    {
        $studentDet = Student::all();

        return response()->json([
            'studentDet' => $studentDet
        ]);
    }

    public function getStudentsByClassId($id)
    {
        $class = Classes::find($id);

        if(!$class) {
            return response()->json([
                'error' => 'This class does not exist!'
            ]);
        }

        $students = $class->students()->get();

        return response()->json([
            'studentDet' => $students
        ]);
    }

    public function changeIsFeePayingSchool(Request $request)
    {
        $value = (int) $request->val;

        $settings = Setting::first();
        $settings->is_fee_paying_school = $value;
        $settings->save();
    }

    public function changeisPrimarySchool(Request $request)
    {
        $value = (int) $request->val;
        
        $settings = Setting::first();
        $settings->is_primary_school = $value;
        $settings->save();
    }

    public function changeisLetStudentsChooseClasses(Request $request)
    {
        $value = (boolean) $request->val;
        
        $settings = Setting::first();
        $settings->is_let_student_choose_classes = $value;
        $settings->save();
    }
}
