<?php

namespace App\Models;

use App\User;
use App\Models\Product;
use App\Scopes\SellerScope;
use App\Transformers\Seller\SellerTransformer;

class Seller extends User
{
    // transformer 
    public $transformer = SellerTransformer::class;

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
