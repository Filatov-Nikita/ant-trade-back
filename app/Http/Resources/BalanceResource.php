<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BalanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'balance' => $this['balance'] / 100,
            'outcome_total' => $this['outcome_total'] / 100,
            'income_total' => $this['income_total'] / 100,
            'operations' => BalanceOperationResource::collection(collect($this['operations'])),
        ];
    }
}
