<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;

class SellerTransactionController extends ApiController
{
    public function __construct()
    {
        // call the prent constructor which has the api auth
        parent::__construct();
        $this->middleware('scope:read-general')->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        $transactions = $seller->products()
            ->whereHas('transactions')
            ->with('transactions')
            ->get()
            ->pluck('transactions')
            ->collapse();

        return $this->showAll($transactions);
    }
}
