<?php

namespace App\Models;

use App\User;
use App\Models\Product;

class Seller extends User
{
    // has many product
    public function products(){
    	return $this->hasMany(Product::class);
    }
}
