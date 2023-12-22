<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'ahmed',
            'email' => 'user@yahoo.com',
            'password' => Hash::make('2545455'),
            'phone_number' => '010202536455',
        ]);

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'ahmed@yahoo.com',
            'password' => Hash::make('admin123'),
            'phone_number' => '012302233499',
        ]);
    }
}
