<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductOrderFlash;
use Illuminate\Database\Eloquent\Builder;



class OrderController extends ApiController
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
            $allOrder = Order::with(['vat', 'flashes', 'customer'])
                ->whereHas('customer', function (Builder $query) use($search){
                    $query->where('name', 'LIKE', "%{$search}%");
                })->orderBy('id', 'desc');
                
                // ->orWhere('vat->province_name', 'LIKE', "%{$search}%")
                
        } else {
            $allOrder = Order::with(['vat', 'flashes', 'customer'])
                ->whereNotNull('id')->orderBy('id', 'desc');
        }

        
        $order = $allOrder->paginate(3);

        if($order){
            return $this->successResponse($order);
        }else{
            return $this->successResponse(null, 'No Order', 404);
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
        // the product_quantity will be transported like {product_id:product_number}
        $product_infos = $request->product_quantity;
        $infos = json_decode($product_infos, true);
        
        $subtotal = 0;
        foreach ($infos as $x => $x_value){
            $product = Product::where('id', $x)
                             ->first();
            $subtotal = $subtotal + $product->selling_price * $x_value;
        }

        $form['subtotal'] = $subtotal;
        $order = Order::create($form);
        

        if($order){
            $lastOrder = Order::latest('id')->get();
            // store data to the product-order-flash table
            $orderId = $lastOrder[0]->id;
            foreach ($infos as $x => $x_value){
                $product = Product::where('id', $x)
                                ->first()->toJson();
                $flash = new ProductOrderFlash();
                $flash->product_id = $x;
                $flash->order_id = $orderId;
                $flash->product_info = $product;
                $flash->save();
            }
            
            return $this->successResponse($order, 'Order Created', 201);
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
        $order = Order::find($id);
        if ($order){
            $order->vat = $order->vat;
            $order->flashes = $order->flashes;
            $order->customer = $order->customer;
            return $this->successResponse($order);
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
        $result = Order::where('id', $id)
                ->update($request->all());
        
        if ($result === 1){
            $order = Order::find($id);
            return $this->successResponse($order, 'Order Updated');
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
       $order = Order::find($id);
       $order->delete();

       if ($order->trashed()){
           return $this->successResponse(null, 'Order Deleted');
       }else{
           return $this->errorResponse('Delete Failed', 401);
       }
    }
}
