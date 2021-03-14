<?php

namespace App\Models;

use App\User;
use App\Models\Transaction;
use App\Scopes\BuyerScope;

class Buyer extends User
{
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
