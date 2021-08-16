<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use Validator;

class EmployeeController extends Controller
{
    public function index(){
        return response()->json(Employee::all());
    }

    public function employeeAdd(Request $request) {
        $v = Validator::make($request->all(), [
            'name'      => 'required|unique:employees,name',
            'birthdate' => 'required',
            'sex'       => 'required',
            'handphone' => 'required',
            'address'   => 'required',
        ]);

        if ($v->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ]);
        }

        $employee = new Employee();
        $employee->name = $request->name;
        $employee->birthdate = date('Y-m-d', strtotime($request->birthdate));
        $employee->sex = $request->sex;
        $employee->address = $request->address;
        $employee->handphone = $request->handphone;
        $employee->save();
        
        return response()->json(['status' => 'success'], 200);

    }

    public function employeeEdit(Request $request) {

        $v = Validator::make($request->all(), [
            'name'      => 'required|unique:employees,name',
            'birthdate' => 'required',
            'sex'       => 'required',
            'handphone' => 'required',
            'address'   => 'required',
        ]);

        if ($v->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ]);
        }

        $employee = Employee::find($request->id);
        $employee->name = $request->name;
        $employee->birthdate = date('Y-m-d', strtotime($request->birthdate));
        $employee->sex = $request->sex;
        $employee->address = $request->address;
        $employee->handphone = $request->handphone;
        $employee->save();
        
        return response()->json(['status' => 'success'], 200);
    }

    public function employeeDelete(Request $request) {
        $employee = Employee::find($request->idEmployee);
        if($employee) {
            $employee->delete();
            return response()->json(['status' => 'success'], 200);
        }
        return response()->json(['status' => 'error', 'errors' => 'Employee Not Found'], 200);
    }
}
