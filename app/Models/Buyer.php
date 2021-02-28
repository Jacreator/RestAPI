<?php

namespace App\Models;

use App\User;
use App\Models\Transaction;

class Buyer extends User
{
    // has many transactions
    public function transactions(){
    	return $this->hasMany(Transaction::class);
    }
}
