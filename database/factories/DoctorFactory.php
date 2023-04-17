<?php

namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'image' => $this->faker->imageUrl(),
            'national_id' => $this->faker->unique()->randomNumber(8),
            'pharmacy_id' => $this->faker->numberBetween(1, 10),
            'is_banned' => $this->faker->boolean,
        ];
    }
}
