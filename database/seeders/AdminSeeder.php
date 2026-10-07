<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminLogin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdminLogin::updateOrCreate(
        ['al_user_name' => 'renukarice@gmail.com'], // unique condition
            [
                'al_name'     => 'Renuka Rice',
                'al_password' => Hash::make('12345678'),
            ]
    );
    }
}
