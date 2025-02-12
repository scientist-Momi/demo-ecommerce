<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{


    public function toArray(Request $request): array
    {
        $customer = $this->whenLoaded('customer');

        // Get the role from the admin relationship
        $status = $customer ? $customer->is_locked : null;

        return [
            'id' => $this->user_id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'phone' => $this->phone,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'is_locked' => $status
        ];
    }
}
