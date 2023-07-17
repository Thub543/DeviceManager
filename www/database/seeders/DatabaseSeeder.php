<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Device;
use App\Models\Employee;
use App\Models\Handover;
use App\Models\Location;
use App\Models\Order;
use App\Models\User;
use Database\Factories\DevicewithOtherStatesFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Only seed if there are no records in the database.
        if (DB::table('locations')->first()) return;

        Location::factory('at_AT')
            ->count(10)
            ->create();

        Employee::factory('at_AT')
            ->count(200)
            ->create();

        Order::factory('at_AT')
            ->count(20)
            ->create();

        $this->call([
            UserTableSeeder::class,
            LocationTableSeeder::class,// for IT
            TypeTableSeeder::class,
            StatusTableSeeder::class,
            DeviceModelTableSeeder::class,
        ]);

        DevicewithOtherStatesFactory::new()
            ->count(50)
            ->create();

        Handover::factory('at_AT')
            ->count(200)
            ->create();
    }
}
