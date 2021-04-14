<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // make the foreign key checks null
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        // dropping table data if present
        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
        DB::table('category_product')->truncate();

        // flush Event incase of mailing and other third party usage
        User::flushEventListeners();
        Category::flushEventListeners();
        Product::flushEventListeners();
        Transaction::flushEventListeners();

        // quantity that should be created
        $userQuantity = 200;
        $categoryQuantity = 30;
        $productsQuantity = 100;
        $transactionsQuantity = 100;

        // creation
        factory(User::class, $userQuantity)->create();
        factory(Category::class, $categoryQuantity)->create();

        // matching product and category info
        factory(Product::class, $productsQuantity)->create()->each(function ($product) {
            $categories = Category::all()->random(mt_rand(1, 5))->pluck('id');
            $product->categories()->attach($categories);
        });

        factory(Transaction::class, $transactionsQuantity)->create();
    }
}
