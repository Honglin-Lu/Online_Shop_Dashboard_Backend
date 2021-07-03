<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class ProductOrderFlash extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'product_order_flash';

    protected $fillable = ['product_id', 'order_id', 'product_info'];

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
