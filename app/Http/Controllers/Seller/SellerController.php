<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;

class SellerController extends Controller
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

        if (is_null($sellers)) {
            return response()->json(['error' => 'No Seller found at the moment', 'code' => 404], 404);
        }

        return response()->json(['totalBuyer' => $sellersTotal, 'data' => $sellers], 201);
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
        return response()->json(['data' => $seller], 201);
    }

}
