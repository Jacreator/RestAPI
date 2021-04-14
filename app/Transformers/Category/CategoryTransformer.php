<?php

namespace App\Transformers\Category;

use League\Fractal\TransformerAbstract;
use App\Models\Category;

class CategoryTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Category $category)
    {
        return [
            // change db to what you want
            "identifier"=> (int) $category->id,
            "title"=> (string) $category->name,
            "details"=> (string) $category->description,
            "createdDate"=> $category->created_at,
            "lastChanged"=> $category->updated_at,
            "deleteDate" => isset($category->deleted_at) ? (string) $category->deleted_at : null,
            "link" => [
                [
                    "rel" => 'self',
                    "href" => route('categories.show', $category->id)
                ],
                [
                    "rel" => 'categories.buyers',
                    "href" => route('categories.buyer.index', $category->id)
                ],
                [
                    "rel" => 'categories.sellers',
                    "href" => route('categories.seller.index', $category->id)
                ],
                [
                    "rel" => 'categories.transactions',
                    "href" => route('categories.transaction.index', $category->id)
                ],
                [
                    "rel" => 'categories.products',
                    "href" => route('categories.product.index', $category->id)
                ],
            ]
        ];
    }

    // to make sure the transformed identifier can be used on url with
    // database names
    public static function originalAttribute($index){
        $attribute = [
            // change db to what you want
            "identifier"=> 'id',
            "title"=> 'name',
            "details"=> 'description',
            "createdDate"=>  'created_at',
            "lastChanged"=>  'updated_at',
            "deleteDate" => 'deleted_at'
        ];

        return isset($attribute[$index]) ? $attribute[$index]: null;
    }

    public static function transformAttribute($index){
        $attribute = [
            // change db to what you want
            'id' => "identifier",
            'name' => "title",
            'description' => "details",
             'created_at' => "createdDate",
             'updated_at' => "lastChanged",
            'deleted_at' => "deleteDate"
        ];

        return isset($attribute[$index]) ? $attribute[$index]: null;
    }
}
