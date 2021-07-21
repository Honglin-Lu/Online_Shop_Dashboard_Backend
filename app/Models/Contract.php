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
        
        $contract_type = config('custom.contract.type');
        return [
            'type_id' => $value,
            'type_name' => array_flip($contract_type)[$value]
        ];
        // return $contract_type[$value];
        // if($value === 0){
        //     $type = "permanent";
        // }elseif($value === 1){
        //     $type = "fixed-term";
        // }else{
        //     $type = "casual";
        // }
        // return $type;
    }

    public function employee(){
        return $this->belongsTo(Employee::class);
    }

}
