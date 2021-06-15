<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;


class DepartmentController extends Controller
{
    public static $childrenId = array();
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allDepartment = Department::whereNotNull('id');
        $allDepartment = Department::with('employees');
        if($request->has('name')){
            $allDepartment = Department::where('name', $request->name);
        }
        if($request->has('parent_id')){
            $allDepartment = Department::where('parent_id', $request->parent_id);
        }
        if($request->has('description')){
            $allDepartment = Department::where('description', $request->description);
        }
        

        return $allDepartment->paginate(3)->toJson();
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $department = Department::create($request->all());
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $department = Department::find($id);
        if ($department){
            $department->employees = $department->employees;
            return $department->toJson();
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
        Department::where('id', $id)
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
        // $this->getAllChildren($id);
        // dump(self::$childrenId);
        // exit();
        
        $result = Department::descendantsAndSelf($id);
        foreach($result as $node){
            $node->delete();
        }
        
      
    }

    // private function getAllChildren($id){
    //     $departments = Department::where('p_id', $id)->get();
       
    //     if($departments){
    //         foreach($departments as $department){
    //             array_push(self::$childrenId, $department->id);
    //             $this->getAllChildren($department->id);
    //         }
    //     }
    // }
}
