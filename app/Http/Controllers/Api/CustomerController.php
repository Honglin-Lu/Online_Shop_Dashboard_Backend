<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Customer;


class CustomerController extends ApiController
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
            $allCustomer = Customer::where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('phone', 'LIKE', "%{$search}%")
                ->orWhere('address', 'LIKE', "%{$search}%")
                ->orderBy('id', 'desc');
        } else {
            $allCustomer = Customer::whereNotNull('id')->orderBy('id', 'desc');
        }

        //return $allCustomer->paginate(3)->toJson();
        $customer = $allCustomer->paginate(3);
        if($customer){
            return $this->successResponse($customer);
        }else{
            return $this->successResponse(null, 'No Customer', 404);
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
            'phone' => 'bail|required|unique:customers|digits:10',
            'email' => 'bail|required|unique:customers|email|max:200',
            'address' => 'nullable|max:200',
            'status' => 'required',
        ]);


        $customer = Customer::create($request->all());
        if($customer){
            return $this->successResponse($customer, 'Customer Created', 201);
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
        $customer = Customer::find($id);
        if ($customer){
            return $this->successResponse($customer);
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
            'phone' => 'bail|required|unique:customers,phone,'. $id .'|digits:10',
            'email' => 'bail|required|unique:customers,email,'. $id .'|email|max:200',
            'address' => 'nullable|max:200',
            'status' => 'required',
        ]);

        $result = Customer::where('id', $id)
                ->update($request->all());
        // If the update is successful, the result equals to 1, and if the update is unsuccessful, the result is 0.
        if ($result === 1){
            $customer = Customer::find($id);
            return $this->successResponse($customer, 'Customer Updated');
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
        $customer = Customer::find($id);
        $customer->delete();
        //Customer::destroy($id);
        if ($customer->trashed()){
            return $this->successResponse(null, 'Customer Deleted');
        }else{
            return $this->errorResponse('Delete Failed', 401);
        }
    }
}
