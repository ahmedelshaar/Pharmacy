<?php

namespace Database\Factories;

use App\Models\Area;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UserAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'street_name' => "Street {$this->faker->randomDigit(10, 100)}",
            'building_number' => $this->faker->randomDigit(1, 100),
            'floor_number' => $this->faker->randomDigit(1, 100),
            'flat_number' => $this->faker->randomDigit(1, 100),
            'is_main' => $this->faker->boolean(0),
            'user_id' => User::all()->random()->id,
            'area_id' => Area::all()->random()->id,
        ];
    }
}
