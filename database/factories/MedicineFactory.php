<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicine>
 */
class MedicineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = $this->faker->randomFloat(0, 1, 100);
        return [
            'name' => $this->faker->name,
            'price' => $price,
            'type_id' => DB::table('medicines_types')->inRandomOrder()->first()->id,

        ];
    }
}
