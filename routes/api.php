<?php

use Illuminate\Http\Request;
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
Route::ApiResource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);
Route::ApiResource('categories.product', 'Category\CategoryProductController', ['only' => ['index']]);
Route::ApiResource('categories.seller', 'Category\CategorySellerController', ['only' => ['index']]);
Route::ApiResource('categories.transaction', 'Category\CategoryTransactionController', ['only' => ['index']]);
Route::ApiResource('categories.buyer', 'Category\CategoryBuyerController', ['only' => ['index']]);

// user
Route::ApiResource('user', 'User\UserController', ['except' => ['create', 'edit']]);
Route::get('user/verify/{token}', 'User\UserController@verify')->name('verify');
Route::get('user/{user}/resend', 'User\UserController@resend')->name('verifyResend');

// transaction
Route::ApiResource('transaction', 'Transaction\TransactionController', ['only' => ['index', 'show']]);
Route::ApiResource('transaction.category', 'Transaction\TransactionCategoryController', ['only' => ['index']]);
Route::ApiResource('transaction.seller', 'Transaction\TransactionSellerController', ['only' => ['index']]);

// Seller
Route::ApiResource('seller', 'Seller\SellerController', ['only' => ['index', 'show']]);
Route::ApiResource('seller.transaction', 'Seller\SellerTransactionController', ['only' => ['index']]);
Route::ApiResource('seller.category', 'Seller\SellerCategoryController', ['only' => ['index']]);
Route::ApiResource('seller.buyer', 'Seller\SellerBuyerController', ['only' => ['index']]);
Route::ApiResource('seller.product', 'Seller\SellerProductController', ['except' => ['show']]);

// Product
Route::ApiResource('product', 'Product\ProductController', ['only' => ['index', 'show']]);
Route::ApiResource('product.transaction', 'Product\ProductTransactionController', ['only' => ['index']]);
Route::ApiResource('product.buyer', 'Product\ProductBuyerController', ['only' => ['index']]);
Route::ApiResource('product.buyer.transaction', 'Product\ProductBuyerTransactionController', ['only' => ['store']]);
Route::ApiResource('product.category', 'Product\ProductCategoryController', ['except' => ['store', 'show']]);

// buyer
Route::ApiResource('buyer', 'Buyer\BuyerController', ['only' => ['index', 'show']]);
Route::ApiResource('buyer.product', 'Buyer\BuyerProductController', ['only' => ['index']]);
Route::ApiResource('buyer.transaction', 'Buyer\BuyerTransactionController', ['only' => ['index']]);
Route::ApiResource('buyer.seller', 'Buyer\BuyerSellerController', ['only' => ['index']]);
Route::ApiResource('buyer.category', 'Buyer\BuyerCategoryController', ['only' => ['index']]);


// oauth token for creating user token
Route::post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
