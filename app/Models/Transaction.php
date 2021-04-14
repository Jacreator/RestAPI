<?php

namespace App\Models;

use App\Models\Buyer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Transformers\Transaction\TransactionTransformer;

class Transaction extends Model
{
    use SoftDeletes;
    // table name
    protected $table = 'transactions';

    // soft delete colume
    protected $date = ['deleted_at'];

    // transformer
    public $transformer = TransactionTransformer::class;

    // fillable area
    protected $fillable = [
        'quantity',
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
