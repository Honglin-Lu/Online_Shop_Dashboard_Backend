<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'buying_price', 'selling_price', 
                           'product_category_id', 'supplier_id', 'quantity', 'description', 
                           'photo', 'status'];


    public function getStatusAttribute($value){
        $product_status = config('custom.product.status');
        return [
            'status_id' => $value,
            'status_name' => array_flip($product_status)[$value]
        ];
        //return $value === 0 ? "on-sale" : "off-shelf";
    }

    public function product_category(){
        return $this->belongsTo(ProductCategory::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
}
