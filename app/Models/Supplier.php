<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'email', 'phone', 'address'];

    public function getStatusAttribute($value){
        $supplier_status = config('custom.supplier.status');
        return [
            'status_id' => $value,
            'status_name' => array_flip($supplier_status)[$value]
        ];
        
        //return $value === 0 ? "normal" : "unnormal";
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
