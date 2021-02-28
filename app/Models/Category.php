<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // table name
    protected $table = 'categorys';

    // fillable feilds
    protected $fillable = [
        'name',
        'description',
    ];

    // has many product
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
