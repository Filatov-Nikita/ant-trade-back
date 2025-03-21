<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operation;
use App\Models\File;
use App\Http\Requests\StoreOperationCashRequest;
use App\Http\Requests\UpdateOperationCashRequest;

class OperationCashController extends Controller
{
    public function store(StoreOperationCashRequest $request) {
        $operation = new Operation();
        $operation->transaction_type = 'cash';
        $operation->sum = $request->input('sum') * 100;
        $operation->fill($request->only([
            'company_id',
            'comment',
            'type',
            'payment_source',
            'date_from',
        ]));
        $operation->save();
        $operation->files()->saveMany(File::find($request->input('files') ?? []));
    }

    public function update(UpdateOperationCashRequest $request, Operation $operation) {
        $operation->sum = $request->input('sum') * 100;
        $operation->fill($request->only([
            'company_id',
            'comment',
            'payment_source',
            'date_from',
        ]));
        $operation->save();
        $operation->files()->saveMany(File::find($request->input('files') ?? []));
    }
}
