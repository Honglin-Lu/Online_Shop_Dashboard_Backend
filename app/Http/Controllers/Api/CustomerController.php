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
        $allCustomer = Customer::whereNotNull('id');

        if($request->has('name')){
            $allCustomer = Customer::where('name', $request->name);
        }
        if($request->has('email')){
            $allCustomer = Customer::where('email', $request->email);
        }
        if($request->has('phone')){
            $allCustomer = Customer::where('phone', $request->phone);
        }
        if($request->has('address')){
            $allCustomer = Customer::where('address', $request->address);
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
