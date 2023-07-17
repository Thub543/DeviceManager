<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['status_name' => 'assigned'],
            ['status_name' => 'in Store'],
            ['status_name' => 'ordered'],
            ['status_name' => 'damaged',],
            ['status_name' => 'repair'],
            ['status_name' => 'deleted'],
            ['status_name' => 'stolen'],
            ['status_name' => 'lost'],
            ['status_name' => 'offboarding'],
        ];

        DB::table('statuses')->insert($statuses);

    }
}
