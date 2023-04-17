<?php

namespace Database\Factories;

use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAddressFactory extends Factory
{
    protected $model = UserAddress::class;

    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'area_id' => $this->faker->numberBetween(1, 10),
            'street_name' => $this->faker->streetName,
            'building_number' => $this->faker->buildingNumber,
            'floor_number' => $this->faker->numberBetween(1, 100),
            'flat_number' => $this->faker->numberBetween(1, 100),
            'is_main' => false,
        ];
    }
}
