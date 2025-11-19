<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Miftakhul Hudha',
            'email' => 'miftakhul.hudha11@gmail.com',
            'password' => Hash::make('B4likp4p4n'), // <- pakai Hash::make
        ]);
    }
}
