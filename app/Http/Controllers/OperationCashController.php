<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operation;
use App\Http\Requests\StoreOperationCashRequest;

class OperationCashController extends Controller
{
    public function store(StoreOperationCashRequest $request) {
        Operation::create(
            $request
            ->safe()
            ->merge([
                'transaction_type' => 'cash',
            ])
            ->all()
        );
    }
}
