<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Création de l'utilisateur admin
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123'),
            'type' => 1,
            'phone' => mt_rand(10000000, 99999999),
        ]);

        // Création des autres utilisateurs
        for ($i = 1; $i <= 10; $i++) {
            User::create([
                'name' => 'employee' . $i,
                'email' => 'employee' . $i . '@gmail.com',
                'password' => bcrypt('123'),
                'type' => 0,
                'phone' => mt_rand(10000000, 99999999),
            ]);
        }
    }
}
