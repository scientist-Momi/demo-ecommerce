<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'order_id' => $this->order_id,
            'customer_id' => $this->customer_id,
            'status' => $this->status,
            'total_amount' => $this->total_amount,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'shipping_fee' => $this->shipping_fee,
            'payment_method' => $this->payment_method,
            'transaction_id' => $this->transaction_id,
            'shipping_address_id' => $this->shipping_address_id,
            'billing_address_id' => $this->billing_address_id,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),

            'shipping_address' => new CustomerAddressResource($this->whenLoaded('shippingAddress')),
            'billing_address' => new CustomerAddressResource($this->whenLoaded('billingAddress')),
        ];
    }
}
