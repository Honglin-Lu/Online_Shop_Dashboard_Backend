<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'email', 'phone', 'address', 'status'];

    public function getStatusAttribute($value){
        $customer_status = config('custom.customer.status');
        return [
            'status_id' => $value,
            'status_name' => array_flip($customer_status)[$value]
        ];
        
        //return $value === 0 ? "normal" : "unnormal";
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

}
