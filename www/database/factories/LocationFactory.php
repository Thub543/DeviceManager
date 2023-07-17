<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    public function setUp(): void
    {
        parent::setUp();
        app(\Faker\Generator::class)->seed(1825);
    }

    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $this->faker->seed(1231123);
        $city = $this->faker->unique()->city();
        $cityWithoutDirection = $this->removeDirections($city);
        $initials = strtoupper(substr($cityWithoutDirection, 0, 3));

        return [
            'location_initials' => $initials,
            'location_name' => $city,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    private function removeDirections($string) {
        $directions = ["East", "West", "North", "South","Lake","New"];
        foreach ($directions as $direction) {
            if (strpos($string, $direction) === 0) {
                $string = trim(str_replace($direction, '', $string));
                break;
            }
        }
        return $string;
    }
}
