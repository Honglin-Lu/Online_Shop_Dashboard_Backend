<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Supplier;


class SupplierController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {



        $search = $request->input('q');
        if ($search){
            $allSupplier = Supplier::where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('phone', 'LIKE', "%{$search}%")
                ->orWhere('address', 'LIKE', "%{$search}%");
        } else {
            $allSupplier = Supplier::whereNotNull('id');
        }

        $supplier = $allSupplier->paginate(3);
        if($supplier){
            return $this->successResponse($supplier);
        }else{
            return $this->successResponse(null, 'No Supplier', 404);
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
        $request->validate([
            'name' => 'bail|required|max:100',
            'phone' => 'bail|required|unique:suppliers|digits:10',
            'email' => 'bail|required|unique:suppliers|email|max:200',
            'address' => 'nullable|max:200',
            'status' => 'required',
        ]);


        $supplier = Supplier::create($request->all());
        if($supplier){
            return $this->successResponse($supplier, 'Supplier Created', 201);
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
       
        $supplier = Supplier::find($id);
        if ($supplier){
            return $this->successResponse($supplier);
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
        $request->validate([
            'name' => 'bail|required|max:100',
            'phone' => 'bail|required|unique:suppliers,phone,'. $id .'|digits:10',
            'email' => 'bail|required|unique:suppliers,email,'. $id .'|email|max:200',
            'address' => 'nullable|max:200',
            'status' => 'required',
        ]);

        $result = Supplier::where('id', $id)
                ->update($request->all());
        // If the update is successful, the result equals to 1, and if the update is unsuccessful, the result is 0.
        if ($result === 1){
            $supplier = Supplier::find($id);
            return $this->successResponse($supplier, 'Supplier Updated');
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
        $supplier = Supplier::find($id);
        $supplier->delete();
        //Customer::destroy($id);
        if ($supplier->trashed()){
            return $this->successResponse(null, 'Supplier Deleted');
        }else{
            return $this->errorResponse('Delete Failed', 401);
        }

    }
}
