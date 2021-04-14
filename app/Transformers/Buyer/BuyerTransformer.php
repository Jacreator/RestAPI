<?php

namespace App\Transformers\Buyer;

use League\Fractal\TransformerAbstract;
use App\Models\Buyer;

class BuyerTransformer extends TransformerAbstract
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
    public function transform(Buyer $buyer)
    {
       return [
            // change db to what you want
            "identifier"=> (int) $buyer->id,
            "userName"=> (string) $buyer->name,
            "userEmail"=> (string) $buyer->email,
            "whenVerified"=> $buyer->email_verified_at,
            "isVerified"=> (int) $buyer->verified,
            "createdDate"=> $buyer->created_at,
            "lastChanged"=> $buyer->updated_at,
            "deleteDate" => isset($buyer->deleted_at) ? (string) $buyer->deleted_at : null,

            "link" => [
                [
                    "rel" => 'self',
                    "href" => route('buyer.show', $buyer->id)
                ],
                [
                    "rel" => 'buyer.seller',
                    "href" => route('buyer.seller.index', $buyer->id)
                ],
                [
                    "rel" => 'buyer.category',
                    "href" => route('buyer.category.index', $buyer->id)
                ],
                [
                    "rel" => 'buyer.product',
                    "href" => route('buyer.product.index', $buyer->id)
                ],
                [
                    "rel" => 'buyer.transaction',
                    "href" => route('buyer.transaction.index', $buyer->id)
                ],
                [
                    "rel" => 'user',
                    "href" => route('user.show', $buyer->id)
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

    public static function transformAttribute($index){
        $attribute = [
            // change db to what you want
            'id' => "identifier",
            'name' => "userName",
            'email' => "userEmail",
            'verified_at' => "whenVerified",
            'verified' => "isVerified",
             'created_at' => "createdDate",
             'updated_at' => "lastChanged",
            'deleted_at' => "deleteDate"
        ];

        return isset($attribute[$index]) ? $attribute[$index]: null;
    }
}
