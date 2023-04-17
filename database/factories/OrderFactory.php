<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'is_insured' => $this->faker->boolean,
            'prescription' => $this->faker->text,
            'status' => $this->faker->randomElement(['New', 'Processing', 'Waiting', 'Canceled', 'Confirmed', 'Delivered']),
            'pharmacy_id' => $this->faker->numberBetween(1, 10),
            'doctor_id' => $this->faker->numberBetween(1, 10),
            'user_id' => $this->faker->numberBetween(1, 10),
            'address_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
