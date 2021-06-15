<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Contract extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['type', 'code', 'starting_date', 'ending_date', 'salary', 'employee_id', 'status'];

    public function getStatusAttribute($value){
        
        return $value === 0 ? "active" : "inactive";
    }

    public function getTypeAttribute($value){
        
        if($value === 0){
            $type = "permanent";
        }elseif($value === 1){
            $type = "fixed-term";
        }else{
            $type = "casual";
        }
        return $type;
    }

}
