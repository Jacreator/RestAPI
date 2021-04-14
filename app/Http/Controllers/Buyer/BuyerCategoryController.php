<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;

class BuyerCategoryController extends ApiController
{
    public function __construct()
    {
        // call the prent constructor which has the api auth
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        // this gets the seller of a particular item by going through buyer, transaction, product and choose it
        // uniquely
        $category = $buyer->transactions()->with('product.categories')->get()
            ->pluck('product.categories')
            ->collapse()
            ->unique('id')
            ->values();

        return $this->showAll($category);
    }

}
