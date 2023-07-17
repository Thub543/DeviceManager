<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;


class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['username' => 'admin', 'password' => Hash::make('1234'), 'isAdmin' => 1],
            ['username' => 'ro', 'password' => Hash::make('1234'), 'isAdmin' => 0],
        ];

        DB::table('users')->insert($users);

    }
}
