<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;


class FeedbackAnswer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'feedback_answers';

    public function getCreatedAtAttribute($value){
        
        return Carbon::parse($value)->format('m/d/y H:i:s');
    }


}
