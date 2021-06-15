<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allEmployee = Employee::whereNotNull('id');
        $allEmployee = Employee::with(['department', 'contracts']);

        if($request->has('name')){
            $allEmployee = Employee::where('name', $request->name);
        }
        if($request->has('email')){
            $allEmployee = Employee::where('email', $request->email);
        }
        if($request->has('phone')){
            $allEmployee = Employee::where('phone', $request->phone);
        }
        if($request->has('birthdate')){
            $allEmployee = Employee::where('birthdate', $request->birthdate);
        }
        if($request->has('address')){
            $allEmployee = Employee::where('address', $request->address);
        }
        if($request->has('contract_id')){
            $allEmployee = Employee::where('contract_id', $request->contract_id);
        }
        if($request->has('department_id')){
            $allEmployee = Employee::where('department_id', $request->department_id);
        }
        if($request->has('status')){
            $allEmployee = Employee::where('status', $request->status);
        }
        
        return $allEmployee->paginate(3)->toJson();
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $employee = Employee::create($request->all());
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);
        if ($employee){
            // $department = $employee->department;
            // $employee->department = 
            $employee->department = $employee->department;
            $employee->contracts = $employee->contracts;
            return $employee->toJson();
        }else{
            return "Invalid Id !";
        }
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Employee::where('id', $id)
                ->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        $employee->delete();
    }
}
