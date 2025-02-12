<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    protected $model = Admin::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'role' => $this->faker->randomElement(['ADMIN', 'CUSTOMER RELATIONS', 'MANAGER']),
            'created_by' => User::factory(), // Assuming an admin is created by another user
        ];
    }
}
