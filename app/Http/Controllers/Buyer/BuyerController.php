<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Buyer;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all the users with transaction id
        $buyers = Buyer::has('transactions')->get();
        $buyersTotal = Buyer::has('transactions')->count();

        if (is_null($buyers)) {
            return response()->json(['error' => 'No Buyer found at the moment', 'code' => 404], 404);
        }

        return response()->json(['totalBuyer' => $buyersTotal, 'data' => $buyers], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get a single buyer
        $buyer = Buyer::has('transactions')->findOrFail($id);
        return response()->json(['data' => $buyer], 201);
    }
}
