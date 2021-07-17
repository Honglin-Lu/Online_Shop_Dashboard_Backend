<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;


use Illuminate\Support\Facades\Gate;



class EmployeeController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allEmployee = Employee::whereNotNull('id');

        // if($request->has('name')){
        //     $allEmployee = Employee::where('name', $request->name);
        // }
        // if($request->has('email')){
        //     $allEmployee = Employee::where('email', $request->email);
        // }
        // if($request->has('phone')){
        //     $allEmployee = Employee::where('phone', $request->phone);
        // }
        // if($request->has('birthdate')){
        //     $allEmployee = Employee::where('birthdate', $request->birthdate);
        // }
        // if($request->has('address')){
        //     $allEmployee = Employee::where('address', $request->address);
        // }
        // if($request->has('contract_id')){
        //     $allEmployee = Employee::where('contract_id', $request->contract_id);
        // }
        // if($request->has('department_id')){
        //     $allEmployee = Employee::where('department_id', $request->department_id);
        // }
        // if($request->has('status')){
        //     $allEmployee = Employee::where('status', $request->status);
        // }
        $search = $request->input('q');
        $allEmployee = Employee::query()
                    ->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhere('address', 'LIKE', "%{$search}%")
                    ->orWhere('birthdate', 'LIKE', "%{$search}%");


        $allEmployee = Employee::with(['department', 'contracts']);

        //return $allEmployee->paginate(3)->toJson();
        $employee = $allEmployee->paginate(3);
        if($employee){
            return $this->successResponse($employee);
        }else{
            return $this->successResponse(null, 'No Employee', 404);
        }
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming HTTP requests
        // stopping on first validation failure:bail
        $request->validate([
            'name' => 'bail|required|max:100',
            'phone' => 'bail|required|unique:employees|digits:10',
            'birthdate' => 'required|date',
            'email' => 'bail|required|unique:employees|email|max:200',
            'address' => 'nullable|max:200',
            'contract_id' => 'nullable|integer',
            'department_id' => 'required|integer',
        ]);


        $employee = Employee::create($request->all());
        if($employee){
            return $this->successResponse($employee, 'Employee Created', 201);
        }else{
            return $this->errorResponse('Store Failed', 401);
        }
        
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
            //return $employee->toJson();
            return $this->successResponse($employee);
        }else{
            return $this->successResponse(null, "Invalid Id !", 404);
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
        
        // if (! Gate::allows('update-employee', auth()->user())) {
        //     abort(403);
        // }



        $request->validate([
            'name' => 'bail|required|max:100',
            'phone' => 'bail|required|unique:employees,phone,'. $id .'|digits:10',
            'birthdate' => 'required|date',
            'email' => 'bail|required|unique:employees,email,'. $id .'|email|max:200',
            'address' => 'nullable|max:200',
            'contract_id' => 'nullable|integer',
            'department_id' => 'required|integer',
        ]);
        
        $result = Employee::where('id', $id)
                ->update($request->all());
        
        if ($result === 1){
            $employee = Employee::find($id);
            return $this->successResponse($employee, 'Employee Updated');
        }else{
            return $this->errorResponse('Update Failed', 401);
        }
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

        if ($employee->trashed()){
            return $this->successResponse(null, 'Employee Deleted');
        }else{
            return $this->errorResponse('Delete Failed', 401);
        }
    }
}
