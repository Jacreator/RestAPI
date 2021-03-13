<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

// categories
Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);

// user
Route::resource('user', 'User\UserController', ['except' => ['create', 'edit']]);

// transaction
Route::resource('transaction', 'Transaction\TransactionController', ['only' => ['index', 'show']]);

// Seller
Route::resource('seller', 'Seller\SellerController', ['only' => ['index', 'show']]);

// Product
Route::resource('product', 'Product\ProductController', ['only' => ['index', 'show']]);

// buyer
Route::resource('buyers', 'Buyer\BuyerController', ['only' => ['index', 'show']]);
