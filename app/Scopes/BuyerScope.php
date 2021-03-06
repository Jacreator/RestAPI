<?php 

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class BuyerScope implements Scope{
    // appling has transactions to any query related to a model
    public function apply(Builder $builder, Model $model)
    {
        $builder->has('transactions');
    }
}