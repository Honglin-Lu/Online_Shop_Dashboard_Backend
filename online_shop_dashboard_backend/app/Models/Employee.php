<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'email', 'phone', 'birthdate', 'address', 'contract_id', 'department_id', 'status'];

    public function getStatusAttribute($value){
        
        if($value === 0){
            $status = "on_work";
        }elseif($value === 1){
            $status = "off_work";
        }else{
            $status = "on_vacation";
        }
        return $status;
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function contracts(){
        return $this->hasMany(Contract::class);
    }
}
