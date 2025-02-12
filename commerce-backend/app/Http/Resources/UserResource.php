<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Nette\Utils\DateTime;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $admin = $this->whenLoaded('admin');

        // Get the role from the admin relationship
        $role = $admin ? $admin->role : null;

        // Get the created_by user's name if available
        $createdBy = $admin && $admin->createdBy ? $admin->createdBy->firstname : null;


        // return [
        //     'id' => $this->user_id,
        //     'firstname' => $this->firstname,
        //     'lastname' => $this->lastname,
        //     'email' => $this->email,
        //     'phone' => $this->phone,
        //     'role' => 'HHHH',
        //     'created_at' => (new DateTime($this->created_at))->format('Y-m-d H:i:s'),
        // ];

        return [
            'id' => $this->user_id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'phone' => $this->phone,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'role' => $role,
            'created_by' => $createdBy,
        ];
    }
}
