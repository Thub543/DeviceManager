<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\DeviceModel;
use App\Models\Location;
use App\Models\Order;
use App\Models\Status;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device>
 */
class DeviceFactory extends Factory
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
        if ($this->faker->boolean(50)) {
            $inv = 'MOB-' . $this->faker->unique()->numberBetween(1000, 3000);
            $typeInitials = 'MOB';
        } else {
            $inv = 'TAB-' . $this->faker->unique()->numberBetween(1000, 3000);
            $typeInitials = 'TAB';
        }

        $typeId = Type::where('type_initials', $typeInitials)->value('id');


        return [
            'inventory_id' => $inv,
            'order_id' => Order::inRandomOrder()->first()->id,
            'warranty' => $this->faker->dateTimeBetween('+1 year', '+2 year'),
            'serial_tag' => $this->faker->optional(30)->swiftBicNumber(),
            'imei' => $this->faker->boolean(30) ? $this->faker->imei() : null,
            'comment' => '',
            'location_id' => Location::where('location_name', 'IT')->value('id'),
            'devicemodel_id' => DeviceModel::where('type_id', $typeId)->inRandomOrder()->first()->id,
            'status_id' => Status::getIdByName('in Store'),
            'user_id' => 1,
            'current_employee_id' => null,
        ];
    }
}
