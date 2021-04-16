<?php

namespace App\Http\Controllers\Product;

use App\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
use App\Transformers\Product\ProductTransformer;

class ProductBuyerTransactionController extends ApiController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:' . ProductTransformer::class)->only(['store']);
        $this->middleware('scope:purchase-product')->only(['store']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product, User $buyer)
    {

        //set quantity rules
        $rules = [
            'quantity' => 'required|integer|min:1',
        ];

        $this->validate($request, $rules);

        // check if the buyer is not the seller itself
        if ($product->seller_id == $buyer->id) {
            # return error
            return $this->errorResponse('the buyer for this item must be different from the seller', 409);
        }

        // check if the buyer is verified
        if (!$buyer->isVerified()) {
            # return error
            return $this->errorResponse('the buyer for this item must be verified', 409);
        }

        // check if the seller is verified
        if (!$product->seller->isVerified()) {
            # return error for seller not verified
            return $this->errorResponse('the seller for this item must be verified', 409);
        }

        // check if product is avaiable
        if (!$product->isAvailable()) {
            # code...
            return $this->errorResponse('Product is not available', 409);
        }

        // check if product quantity is less than the requested quantity
        if ($product->quantity < $request->quantity) {
            # code...
            return $this->errorResponse('Product does not have enough unit for this transaction', 409);
        }

        return DB::transaction(function () use ($request, $product, $buyer) {
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id,
            ]);

            return $this->showOne($transaction);
        });
    }
}
