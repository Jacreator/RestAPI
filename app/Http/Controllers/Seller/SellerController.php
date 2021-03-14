<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;

class SellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all the users with products id
        $sellers = Seller::has('products')->get();
        $sellersTotal = Seller::has('products')->count();

        return $this->showAll($sellers);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get a single seller
        $seller = Seller::has('products')->findOrFail($id);
        return $this->showOne($seller);
    }

}
