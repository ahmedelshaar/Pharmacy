<?php

namespace Database\Factories;

use App\Models\OrderMedicine;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderMedicineFactory extends Factory
{
    protected $model = OrderMedicine::class;

    public function definition(): array
    {
        return [
            'order_id' => $this->faker->numberBetween(1, 10),
            'medicine_id' => $this->faker->numberBetween(1, 10),
            'quantity' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->numberBetween(1000, 100000),
            'cost' => $this->faker->numberBetween(1000, 100000),
        ];
    }
}
