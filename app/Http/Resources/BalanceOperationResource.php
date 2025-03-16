<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BalanceOperationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $item = [
            'id' => $this->id,
            'company' => new CompanyResource($this->company),
            'sum' => $this->sum / 100,
            'type' => $this->type,
            'transaction_type' => $this->transaction_type,
            'payment_source' => $this->payment_source,
            'created_at' => $this->created_at,
        ];

        if($this->transaction_type === 'products') {
            $item['products'] = BalanceProductResource::collection($this->products);
        }

        return $item;
    }
}
