<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //category seed
        $category = new \App\Models\Category();
        
        $category->nom = 'Fruits';
        $category->description = 'Fruits';
        $category->save();


        $category->nom = 'Légumes';
        $category->description = 'Légumes';
        $category->save();


        $category->nom = 'Fleurs';
        $category->description = 'Fleurs';
        $category->save();


        $category->nom = 'Plantes aromatiques';
        $category->description = 'Plantes aromatiques';
        $category->save();


        $category->nom = 'Plantes médicinales';
        $category->description = 'Plantes médicinales';
        $category->save();


        $category->nom = 'Plantes ornementales';
        $category->description = 'Plantes ornementales';
        $category->save();
    }
}
