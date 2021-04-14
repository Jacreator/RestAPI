<?php

namespace App\Transformers\Transaction;

use League\Fractal\TransformerAbstract;
use App\Models\Transaction;

class TransactionTransformer extends TransformerAbstract
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
    public function transform(Transaction $transaction)
    {
        return [
            // change db to what you want
            "identifier"=> (int) $transaction->id,
            "quantity"=> (string) $transaction->quantity,
            "buyer"=> (string) $transaction->buyer_id,
            "product"=> (int) $transaction->product_id,
            "createdDate"=> $transaction->created_at,
            "lastChanged"=> $transaction->updated_at,
            "deleteDate" => isset($transaction->deleted_at) ? (string) $transaction->deleted_at : null,

            "link" => [
                [
                    "rel" => 'self',
                    "href" => route('transaction.show', $transaction->id)
                ],
                [
                    "rel" => 'transaction.seller',
                    "href" => route('transaction.seller.index', $transaction->id)
                ],
                [
                    "rel" => 'transaction.category',
                    "href" => route('transaction.category.index', $transaction->id)
                ],
                [
                    "rel" => 'buyer',
                    "href" => route('buyer.show', $transaction->buyer_id)
                ],
                [
                    "rel" => 'product',
                    "href" => route('product.show', $transaction->product_id)
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
            "quantity"=> 'quantity',
            "buyer"=> 'buyer_id',
            "product"=> 'product_id',
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
            'quantity' => "quantity",
            'buyer_id' => "buyer",
            'product_id' => "product",
            'created_at' => "createdDate",
            'updated_at' => "lastChanged",
            'deleted_at' => "deleteDate"
        ];

        return isset($attribute[$index]) ? $attribute[$index]: null;
    }  
}
