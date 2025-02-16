<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operation;
use App\Models\Product;
use App\Http\Requests\StoreOperationProductRequest;

class OperationProductController extends Controller
{
    public function store(StoreOperationProductRequest $request) {
        $operation = new Operation();

        $sum = 0;
        $products_map = [];

        foreach($request->input('products') as $product) {
            $products_map[$product['id']] = [
                'price' => $product['price'],
                'count' => $product['count'],
            ];

            $sum += $product['count'] * $product['price'];
        }

        $operation->fill(
            $request
            ->safe()
            ->merge([
                'transaction_type' => 'products',
                'sum' => $sum,
            ])
            ->except('products'),
        )->save();

        $operation->products()->attach($products_map);
    }
}
