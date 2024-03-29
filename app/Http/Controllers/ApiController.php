<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponser;

class ApiController extends Controller
{
    //using the general responser
    use ApiResponser;

    public function __construct()
    {
    	$this->middleware('auth:api');
    }
}
