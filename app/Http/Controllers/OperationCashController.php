<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operation;
use App\Models\File;
use App\Http\Requests\StoreOperationCashRequest;

class OperationCashController extends Controller
{
    public function store(StoreOperationCashRequest $request) {
        $operation = new Operation();
        $operation->transaction_type = 'cash';
        $operation->sum = $request->input('sum') * 100;
        $operation->fill($request->only(['company_id', 'comment', 'type']));
        $operation->save();
        foreach($request->input('files') as $fileId) {
            $operation->files()->save(File::find($fileId));
        }
    }
}
