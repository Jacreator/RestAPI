<?php

namespace App\Models;

use App\Models\Seller;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    // table name
    protected $table = 'products';
    protected $date = ['deleted_at'];

    // product status
    const AVILABLE_PRODUCT = 'available';
    const UNAVILABLE_PRODUCT = 'unavilable';

    // fillable feilds
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id',
    ];

    // avilable function
    public function isAvailable()
    {
        return $this->status == Product::AVILABLE_PRODUCT;
    }

    // belongs to category child relationship
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // belongs to a seller
    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    // has many transactions
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
