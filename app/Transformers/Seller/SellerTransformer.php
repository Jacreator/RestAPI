<?php

namespace App\Transformers\Seller;

use League\Fractal\TransformerAbstract;
use App\Models\Seller;

class SellerTransformer extends TransformerAbstract
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
    public function transform(Seller $seller)
    {
        return [
            // change db to what you want
            "identifier"=> (int) $seller->id,
            "userName"=> (string) $seller->name,
            "userEmail"=> (string) $seller->email,
            "whenVerified"=> $seller->email_verified_at,
            "isVerified"=> (int) $seller->verified,
            "createdDate"=> $seller->created_at,
            "lastChanged"=> $seller->updated_at,
            "deleteDate" => isset($seller->deleted_at) ? (string) $seller->deleted_at : null,
            "link" => [
                [
                    "rel" => 'self',
                    "href" => route('seller.show', $seller->id)
                ],
                [
                    "rel" => 'seller.buyer',
                    "href" => route('seller.buyer.index', $seller->id)
                ],
                [
                    "rel" => 'buyer.category',
                    "href" => route('seller.category.index', $seller->id)
                ],
                [
                    "rel" => 'seller.product',
                    "href" => route('seller.product.index', $seller->id)
                ],
                [
                    "rel" => 'seller.transaction',
                    "href" => route('seller.transaction.index', $seller->id)
                ],
                [
                    "rel" => 'user',
                    "href" => route('user.show', $seller->id)
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
            "userName"=> 'name',
            "userEmail"=> 'email',
            "whenVerified"=> 'verified_at',
            "isVerified"=> 'verified',
            "createdDate"=>  'created_at',
            "lastChanged"=>  'updated_at',
            "deleteDate" => 'deleted_at'
        ];

        return isset($attribute[$index]) ? $attribute[$index]: null;
    }

    // transforming data on validation
    public static function transformAttribute($index){
        $attribute = [
            // change db to what you want
            'id' => 'identifier',
            'name' => 'userName',
            'email' => 'userEmail',
            'verified_at' => 'whenVerified',
            'verified' => 'isVerified',
            'created_at' => 'createdDate',
            'updated_at' => 'lastChanged',
            'deleted_at' => 'deleteDate'
        ];

        return isset($attribute[$index]) ? $attribute[$index]: null;
    }
}
