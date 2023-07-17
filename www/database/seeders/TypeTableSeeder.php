<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['type_name' => 'Smartphone',   'type_initials' => 'MOB','isStationary' => false ], //1
            ['type_name' => 'Tablet',       'type_initials' => 'TAB','isStationary' => false ], //2
            ['type_name' => 'Display',      'type_initials' => 'DSP','isStationary' => false ],//3
            ['type_name' => 'Printer',      'type_initials' => 'PRN','isStationary' => true ],//4
            ['type_name' => 'PC',           'type_initials' => 'PCS','isStationary' => false ],//5
            ['type_name' => 'Laptop',        'type_initials' => 'LAP','isStationary' => false ],//6
            ['type_name' => 'Navigation',        'type_initials' => 'NAV','isStationary' => false ],//7
            ['type_name' => 'Dockingstation',        'type_initials' => 'DOS','isStationary' => false ],//8
            ['type_name' => 'Workingstation',        'type_initials' => 'WOS','isStationary' => false ],//9
        ];


        DB::table('types')->insert($types);

    }
}
