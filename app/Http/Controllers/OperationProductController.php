<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operation;
use App\Models\Product;
use App\Models\File;
use App\Http\Requests\StoreOperationProductRequest;
use App\Http\Requests\UpdateOperationProductRequest;

class OperationProductController extends Controller
{
    public function store(StoreOperationProductRequest $request) {
        $operation = new Operation();

        $products = $request->collect('products');

        $operation->fill(
            $request
            ->safe()
            ->merge([
                'transaction_type' => 'products',
                'payment_source' => 'products',
                'sum' => $this->calc_sum($products),
            ])
            ->except('products'),
        )->save();

        $operation->products()->attach($this->get_products_map($products));

        $operation->files()->saveMany(File::find($request->input('files') ?? []));
    }

    public function update(UpdateOperationProductRequest $request, Operation $operation) {
        $products = $request->collect('products');

        $operation->fill(
            $request
            ->safe()
            ->merge([ 'sum' => $this->calc_sum($products) ])
            ->except('products'),
        )->save();

        $operation->products()->sync($this->get_products_map($products));

        $operation->files()->saveMany(File::find($request->input('files') ?? []));
    }

    protected function calc_sum($products) {
        return $products->reduce(function($sum, $product) {
            $sum += $product['count'] * $product['price'] * 100;
            return $sum;
        }, 0);
    }

    protected function get_products_map($products) {
        return $products->reduce(function($map, $product) {
            $map[$product['id']] = [
                'price' => $product['price'] * 100,
                'count' => $product['count'],
            ];
            return $map;
        }, []);
    }
}
