<?php

namespace App\Models;

use App\Models\Buyer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    // table name
    protected $table = 'transactions';
    protected $date = ['deleted_at'];

    // fillable area
    protected $fillable = [
        'qunatity',
        'buyer_id',
        'product_id',
    ];

    // belongs to a buyer
    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }

    // belongs to Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
