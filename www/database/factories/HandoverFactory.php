<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\Employee;
use App\Models\Handover;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Handover>
 */
class HandoverFactory extends Factory
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
        $emp = Employee::inRandomOrder()->first()->id;
        $device = Device::Factory()->create();
        $handoverDate = $this->faker->dateTimeBetween('-2 year', 'now');
        $returnDate = null;

        $device->update([
            'current_employee_id' => $emp,
            'last_employee_id' => null,
            'status_id' => Status::getIdByName('assigned')
        ]);

        if ($this->faker->boolean(30)) {
            $returnDate = $this->faker->dateTimeBetween($handoverDate, 'now');

            $device->update([
                'current_employee_id' => null,
                'last_employee_id' => $emp,
                'status_id' => Status::getIdByName('in Store')
            ]);
        }

        return [
            'handover_date' => $handoverDate,
            'return_date' => $returnDate,
            'device_id' => $device->id,
            'employee_id' => $emp,
            'user_id' => 1,
        ];
    }
}
