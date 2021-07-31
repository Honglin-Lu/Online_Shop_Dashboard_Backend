<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Vat;


class VatController extends ApiController
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
            $allVat = Vat::where('province_name', 'LIKE', "%{$search}%")->orderBy('id', 'desc');
                
        } else {
            $allVat = Vat::whereNotNull('id')->orderBy('id', 'desc');

        }
        

        $vat = $allVat->paginate(3);
        if($vat){
            return $this->successResponse($vat);
        }else{
            return $this->successResponse(null, 'No Vat', 404);
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
            'province_name' => 'bail|required|unique:vats|max:100',
            'federal_rate' => 'bail|required|regex:/^\d+(\.\d{1,3})?$/',
            'province_rate' => 'bail|required|regex:/^\d+(\.\d{1,3})?$/',
           
        ]);

        $vat = Vat::create($request->all());
        if($vat){
            return $this->successResponse($vat, 'Value Added Tax Created', 201);
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
        $vat = Vat::find($id);
        if ($vat){
            return $this->successResponse($vat);
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
            'province_name' => 'bail|required|unique:vats,province_name, '. $id .'|max:100',
            'federal_rate' => 'bail|required|regex:/^\d+(\.\d{1,3})?$/',
            'province_rate' => 'bail|required|regex:/^\d+(\.\d{1,3})?$/',
           
        ]);

        $result = Vat::where('id', $id)
                ->update($request->all());

        if ($result === 1){
            $vat = Vat::find($id);
            return $this->successResponse($vat, 'Vat Updated');
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
        $vat = Vat::find($id);
        $vat->delete();

        if ($vat->trashed()){
            return $this->successResponse(null, 'Vat Deleted');
        }else{
            return $this->errorResponse('Delete Failed', 401);
        }
    }
}
