<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstname = fake()->firstName();
        $lastname = fake()->lastName();
        return [
            'fullname' => $firstname . ' ' . $lastname,
            'email' => strtolower($firstname) . '.' . strtolower($lastname) . '@example.com',
            'password' => bcrypt('123456'),
            'join_date' => Carbon::now(),
        ];
    }
}
