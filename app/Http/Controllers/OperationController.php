<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Operation;
use App\Http\Resources\BalanceResource;
use App\Http\Resources\OperationShowResource;
use App\Http\Requests\BalanceRequest;
use App\Events\OperationRemoved;

class OperationController extends Controller
{
    public function index(BalanceRequest $request)
    {
        $operations = Operation::latest()
            ->with(['company', 'products'])
            ->whereDate('created_at', '>=', $request->input('date_from'))
            ->whereDate('created_at', '<=', $request->input('date_to'))
            ->when($request->input('company'), function($query, $company) {
                $query->where('company_id', $company);
            })
            ->get();

        $balance = 0;

        foreach($operations as $operation) {
            if($operation->type === 'purchase') {
                $balance -= $operation->sum;
            } else {
                $balance += $operation->sum;
            }
        }

        return new BalanceResource([
            'operations' => $operations,
            'balance' => $balance,
        ]);
    }

    public function show(Operation $operation)
    {
        return new OperationShowResource($operation);
    }

    public function destroy(Operation $operation) {
        $operation->delete();
        OperationRemoved::dispatch($operation);
    }
}
