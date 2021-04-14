<?php

namespace App\Models;

use App\User;
use App\Models\Transaction;
use App\Scopes\BuyerScope;
use App\Transformers\Buyer\BuyerTransformer;

class Buyer extends User
{

	// transformer 
	public $transformer = BuyerTransformer::class;
    protected static function boot(){
        parent::boot();

        // adding a global scope of has transaction to buyer model
        static::addGlobalScope(new BuyerScope);
    }
    
    // has many transactions
    public function transactions(){
    	return $this->hasMany(Transaction::class);
    }
}
