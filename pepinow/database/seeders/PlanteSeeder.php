<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //plante seed
        $plante = new \App\Models\Plante();

        $plante->nom = 'Tomate';
        $plante->description = 'Tomate';
        $plante->save();

        $plante->nom = 'Poivron';
        $plante->description = 'Poivron';
        $plante->save();

        $plante->nom = 'Courgette';
        $plante->description = 'Courgette';
        $plante->save();

    }
}
