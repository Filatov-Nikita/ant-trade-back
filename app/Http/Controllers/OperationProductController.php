<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operation;
use App\Models\Product;
use App\Models\File;
use App\Http\Requests\StoreOperationProductRequest;

class OperationProductController extends Controller
{
    public function store(StoreOperationProductRequest $request) {
        $operation = new Operation();

        $sum = 0;
        $products_map = [];

        foreach($request->input('products') as $product) {
            $products_map[$product['id']] = [
                'price' => $product['price'] * 100,
                'count' => $product['count'],
            ];

            $sum += $product['count'] * $product['price'] * 100;
        }

        $operation->fill(
            $request
            ->safe()
            ->merge([
                'transaction_type' => 'products',
                'payment_source' => 'products',
                'sum' => $sum,
            ])
            ->except('products'),
        )->save();

        $operation->products()->attach($products_map);

        foreach($request->input('files') as $fileId) {
            $operation->files()->save(File::find($fileId));
        }
    }
}
