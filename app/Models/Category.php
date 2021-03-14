<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    // table name
    protected $table = 'categorys';
    protected $date = ['deleted_at'];

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
