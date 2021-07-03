<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vat;


class VatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allVat = Vat::whereNotNull('id');

        if($request->has('province_name')){
            $allVat = Vat::where('province_name', $request->province_name);
        }
        if($request->has('federal_rate')){
            $allVat = Vat::where('federal_rate', $request->federal_rate);
        }
        if($request->has('province_rate')){
            $allVat = Vat::where('province_rate', $request->province_rate);
        }
       

        return $allVat->paginate(3)->toJson();
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vat = Vat::create($request->all());
       
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
            return $vat->toJson();
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
        Vat::where('id', $id)
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
        Vat::destroy($id);
    }
}
