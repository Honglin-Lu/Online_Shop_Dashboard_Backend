<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ConfigureController extends ApiController
{
    public function getConfigration(){
        $value = config('custom');
 
        return $this->successResponse($value);
    }
}
