<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Contract;

class ContractController extends ApiController
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
            $allContract = Contract::with('employee')
                    ->where('code', 'LIKE', "%{$search}%")
                    ->orWhere('starting_date', 'LIKE', "%{$search}%")
                    ->orWhere('ending_date', 'LIKE', "%{$search}%")
                    ->orWhere('salary', 'LIKE', "%{$search}%")
                    //->orWhere('type', 'LIKE', "%{$search}%")
                    ->orWhere('status', 'LIKE', "%{$search}%");
        }else{
            $allContract = Contract::with('employee')->whereNotNull('id');

        }
        


        //$allContract = Contract::with('employee');


        //return $allContract->paginate(3)->toJson();
        $contract = $allContract->paginate(3);
        if($contract){
            return $this->successResponse($contract);
        }else{
            return $this->successResponse(null, 'No Contract', 404);
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

        $form = $request->all();

        //create the contract code automatically
        $lastData = Contract::withTrashed()->latest('id')->get();
        // dump($lastData->isEmpty());
        // exit;
        if($lastData->isEmpty()){
            $form['code'] = 'OLS1000';
            
        }else{
            $lastCode = $lastData[0]->code;
            $number = intval(substr($lastCode, 3));
            $number += 1;
            $form['code'] = 'OLS'.$number;
        }

        $contract = Contract::create($form);
        if($contract){
            return $this->successResponse($contract, 'Contract Created', 201);
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
        $contract = Contract::find($id);
        if ($contract){
            $contract->employee = $contract->employee;
            return $this->successResponse($contract);
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
        $result = Contract::where('id', $id)
                ->update($request->all());
               
        if ($result === 1){
            $contract = Contract::find($id);
            return $this->successResponse($contract, 'Contract Updated');
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
        $contract = Contract::find($id);
        $contract->delete();

        if ($contract->trashed()){
            return $this->successResponse(null, 'Contract Deleted');
        }else{
            return $this->errorResponse('Delete Failed', 401);
        }

    }
}
