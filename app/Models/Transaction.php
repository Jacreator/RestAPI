<?php

namespace App\Models;

use App\Models\Buyer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    // table name
    protected $table = 'transactions';

    // fillable area
    protected $fillable = [
    	'qunatity',
    	'buyer_id',
    	'product_id'
    ];

    // belongs to a buyer
    public function buyer(){
    	return $this->belongsTo(Buyer::class);
    }

    // belongs to Product
    public function product(){
    	return $this->belongsTo(Product::class);
    }
}
