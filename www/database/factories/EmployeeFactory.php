<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{

    public function setUp(): void
    {
        parent::setUp();
        app(\Faker\Generator::class)->seed(1825);
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'firstname' => $this->faker->firstName(),
            'surname' => $this->faker->lastName(),
            'location_id' => Location::inRandomOrder()->first()->id,
            'personal_number' => $this->faker->boolean(70) ? 'P' . $this->faker->unique()->randomNumber(6) : null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
