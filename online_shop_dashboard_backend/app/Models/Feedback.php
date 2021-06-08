<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'feedback';

    /**
     * Accessor to transform the field status value after you 
     * fetch the original data from table
     */
    public function getStatusAttribute($value){
        
        return $value === 0 ? "unprocessed" : "processed";
    }
}
