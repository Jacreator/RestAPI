<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Transformers\Category\CategoryTransformer;

class Category extends Model
{
    use SoftDeletes;
    // table name
    protected $table = 'categorys';

    // soft delete colume
    protected $date = ['deleted_at'];

    // transformers
    public $transformer = CategoryTransformer::class;

    // fillable feilds
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pivot'
    ];

    // has many product
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
