<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;



class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['customer_id', 'product_quantity', 'subtotal', 'vat_id', 'status'];

    // public function getStatusAttribute($value){
        
    //     if($value === 0){
    //         $status = "processing";
    //     }elseif($value === 1){
    //         $status = "completed";
    //     }else{
    //         $status = "closed";
    //     }
    //     return $status;
    // }

    public function flashes(){
        return $this->hasMany(ProductOrderFlash::class);
    }

    public function vat(){
        return $this->belongsTo(Vat::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function getCreatedAtAttribute($value){
        
        return Carbon::parse($value)->format('m/d/y H:i:s');
    }
}