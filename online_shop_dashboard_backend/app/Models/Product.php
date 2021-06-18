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
        
        return $value === 0 ? "on-sale" : "off-shelf";
    }
}
