<?php

namespace App\Transformers\Product;

use League\Fractal\TransformerAbstract;
use App\Models\Product;

class ProductTransformer extends TransformerAbstract
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
    public function transform(Product $product)
    {
        return [
            // change db to what you want
            "identifier"=> (int) $product->id,
            "title"=> (string) $product->name,
            "details"=> (string) $product->description,
            "stock"=> (int) $product->quantity,
            "situation"=> (string) $product->status,
            "picture"=> url("images/$product->image"),
            "seller"=> (int) $product->seller_id,
            "createdDate"=> $product->created_at,
            "lastChanged"=> $product->updated_at,
            "deleteDate" => isset($product->deleted_at) ? (string) $product->deleted_at : null,

            "link" => [
                [
                    "rel" => 'self',
                    "href" => route('product.show', $product->id)
                ],
                [
                    "rel" => 'product.buyers',
                    "href" => route('product.buyer.index', $product->id)
                ],
                [
                    "rel" => 'seller',
                    "href" => route('seller.show', $product->seller_id)
                ],
                [
                    "rel" => 'product.transactions',
                    "href" => route('product.transaction.index', $product->id)
                ],
                [
                    "rel" => 'product.category',
                    "href" => route('product.category.index', $product->id)
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
            "stock"=> 'quantity',
            "situation"=> 'status',
            "picture"=> 'image',
            "seller"=> 'seller_id',
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
            'quantity' => "stock",
            'status' => "situation",
            'image' => "picture",
            'seller_id' => "seller",
            'created_at' => "createdDate",
            'updated_at' => "lastChanged",
            'deleted_at' => "deleteDate"
        ];

        return isset($attribute[$index]) ? $attribute[$index]: null;
    }
}
