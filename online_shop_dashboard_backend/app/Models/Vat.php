<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Vat extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['province_name', 'federal_rate', 'province_rate'];

}
