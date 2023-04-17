<?php

namespace Database\Factories;

use App\Models\Pharmacy;
use Illuminate\Database\Eloquent\Factories\Factory;

class PharmacyFactory extends Factory
{
    protected $model = Pharmacy::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'avatar' => $this->faker->imageUrl(),
            'priority' => $this->faker->numberBetween(1, 5),
            'area_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
