<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class FeedbackAnswer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'feedback_answers';
    //protected $dateFormat = 'Y-m-d';

}
