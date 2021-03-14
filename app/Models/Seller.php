<?php

namespace App\Models;

use App\User;
use App\Models\Product;
use App\Scopes\SellerScope;

class Seller extends User
{
    protected static function boot()
    {
        parent::boot();

        // adding seller scope 
        static::addGlobalScope(new SellerScope);
    }
    // has many product
    public function products(){
    	return $this->hasMany(Product::class);
    }
}
