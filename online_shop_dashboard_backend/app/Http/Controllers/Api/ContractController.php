<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contract;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allContract = Contract::whereNotNull('id');
        $allContract = Contract::with('employee');
        if($request->has('code')){
            $allContract = Contract::where('code', $request->code);
        }
        if($request->has('type')){
            $allContract = Contract::where('type', $request->type);
        }
        if($request->has('starting_date')){
            $allContract = Contract::where('starting_date', $request->starting_date);
        }
        if($request->has('ending_date')){
            $allContract = Contract::where('ending_date', $request->ending_date);
        }
        if($request->has('salary')){
            $allContract = Contract::where('salary', $request->salary);
        }
        if($request->has('employee_id')){
            $allContract = Contract::where('employee_id', $request->employee_id);
        }
        if($request->has('status')){
            $allContract = Contract::where('status', $request->status);
        }

        // return response()->json($allFeedback);
        return $allContract->paginate(3)->toJson();
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

        //create the contract id automatically
        $lastData = Contract::withTrashed()->latest('id')->get();
        if($lastData){
            $lastCode = $lastData[0]->code;
            $number = intval(substr($lastCode, 3));
            $number += 1;
            $form['code'] = 'OLS'.$number;
        }else{
            $form['code'] = 'OLS1000';
        }

        $contract = Contract::create($form);
        
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
            return $contract->toJson();
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
        Contract::where('id', $id)
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
        $contract = Contract::find($id);
        $contract->delete();

    }
}
