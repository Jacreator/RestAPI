<?php

namespace App\Http\Controllers\Seller;

use App\User;
use App\Models\Seller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;
use App\Transformers\Seller\SellerTransformer;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends ApiController
{

    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:' . SellerTransformer::class)->only(['store', 'update']);
        $this->middleware('scope:manage-products')->except('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        // using condition to check scopes
        if (request()->user()->tokenCan('read-general') || request()->user()->tokensCan('manage-products')) {
            
            $products = $seller->products;

            return $this->showAll($products);
            // return response()->json($products);
        }

        throw new AuthorizationException;
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $seller)
    {
        //
        $rules = [
            'name' => 'required|string|min:2',
            'description' => 'required|string|min:20',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image',
        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $data['status'] = Product::UNAVILABLE_PRODUCT;
        $data['image'] = $request->image->store('');
        $data['seller_id'] = $seller->id;

        $product = Product::create($data);

        return $this->showOne($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Seller $seller, Product $product)
    {
        //
        $rules = [
            'quantity' => 'integer|min:1',
            'status' => 'in:' . Product::UNAVILABLE_PRODUCT . ',' . Product::AVILABLE_PRODUCT,
            'image' => 'image',
        ];

        $this->validate($request, $rules);

        $this->checkSeller($seller, $product);

        // check and fill the request
        $product->fill($request->only([
            'name',
            'description',
            'quantity',
        ]));

        if ($request->has('status')) {
            $product->status = $request->status;
            if ($product->isAvailable() && $product->categories()->count() == 0) {
                # throw error
                return $this->errorResponse("An active product must at least have one category", 409);
            }
        }

        // updating a file/image
        if($request->hasFile('image')){
            Storage::delete($product->image);
            $product->image = $request->image->store('');
        }

        if ($product->isClean()) {
            # return no changes made
            return $this->errorResponse("You need to specify at least one different value to update", 422);
        }

        // save the instance
        $product->save;

        // return the saved data
        return $this->showOne($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller, Product $product)
    {
        // check the user
        $this->checkSeller($seller, $product);

        Storage::delete($product->image);
        $product->delete();

        return $this->showOne($product);

    }

    protected function checkSeller(Seller $seller, Product $product)
    {
        if ($seller->id != $product->seller_id) {
            throw new HttpException(422, 'the Specified User is not the actual Owner for the product');
        }
    }
}
