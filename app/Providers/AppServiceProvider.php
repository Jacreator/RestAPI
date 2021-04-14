<?php

namespace App\Providers;

use App\Mail\User\UserChangeMail;
use App\Mail\User\UserCreated;
use App\Models\Product;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // set default string length
        Schema::defaultStringLength(191);

        // check for newly created user and send verification information
        User::created(function ($user) {
            // retry sending the email 5 times for failed attempt in 5 seconds for
            retry(5, function () use ($user) {
                Mail::to($user)->send(new UserCreated($user));
            }, 500);
        });

        // check for email updated user and send verification information
        User::updated(function ($user) {
            if ($user->isDirty('email')) {
                // send mail
                Mail::to($user)->send(new UserChangeMail($user));
            }
        });

        // Check for chagnes in Product update
        Product::updated(function ($product) {
            if ($product->quantity == 0 && $product->isAvailable()) {
                $product->status = Product::UNAVILABLE_PRODUCT;

                $product->save();
            }
        });
    }
}
