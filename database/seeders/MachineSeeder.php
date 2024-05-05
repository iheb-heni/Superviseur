<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Machine;
use Illuminate\Database\Seeder;

class MachineSeeder extends Seeder
{
    public function run()
    {
        // Obtenez tous les utilisateurs de type 0
        $users = User::where('type', 0)->get();

        // Si aucun utilisateur de type 0 n'est trouvé, affichez un message d'erreur et arrêtez le seeder
        if ($users->isEmpty()) {
            $this->command->error("Aucun utilisateur de type 0 trouvé. Veuillez créer des utilisateurs de type 0 avant d'exécuter ce seeder.");
            return;
        }

        // Parcourez tous les utilisateurs de type 0 et associez chaque machine à un utilisateur différent
        $machineCount = 40; // Nombre de machines à créer
        $userCount = $users->count(); // Nombre total d'utilisateurs de type 0
        for ($i = 0; $i < $machineCount; $i++) {
            // Obtenez l'utilisateur de type 0 pour cette machine
            $user = $users[$i % $userCount];

            // Créez la machine avec les valeurs spécifiques pour chaque colonne et l'ID de l'utilisateur
            Machine::create([
                'user_id' => $user->id,
                'TIM' => 0,
                'TDG' => 0,
                'TP' => 3,
                'TI' => 2,
                'TO' => 0,
            ]);
        }
    }
}
