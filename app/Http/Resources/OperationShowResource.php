<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OperationShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'transaction_type' => $this->transaction_type,
            'payment_source' => $this->payment_source,
            'sum' => $this->sum / 100,
            'company' => new CompanyResource($this->company),
            'files' => FileResource::collection($this->files),
            'products' => BalanceProductResource::collection($this->products),
            'comment' => $this->comment,
            'date_from' => $this->date_from,
            'created_at' => $this->created_at,
        ];
    }
}
