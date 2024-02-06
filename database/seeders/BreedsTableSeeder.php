<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class BreedsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dogBreeds = ['Labrador Retriever', 'German Shepherd', 'Golden Retriever', 'Bulldog', 'Beagle', 'Poodle', 'Rottweiler', 'Yorkshire Terrier', 'Boxer', 'Dachshund', 'Siberian Husky', 'Pembroke Welsh Corgi', 'Doberman Pinscher', 'Great Dane', 'Shih Tzu', 'Boston Terrier', 'Pomeranian', 'Havanese', 'Shetland Sheepdog', 'Cavalier King Charles Spaniel'];
        $catBreeds = ['Persian', 'Maine Coon', 'Siamese', 'Bengal', 'Ragdoll', 'Sphynx', 'Abyssinian', 'Scottish Fold', 'British Shorthair', 'Russian Blue', 'Norwegian Forest', 'Turkish Van', 'Burmese', 'Himalayan', 'Manx', 'Oriental Shorthair', 'Devon Rex', 'American Bobtail', 'Cornish Rex', 'Balinese'];


        // Insert a new row to the breeds table
        DB::table('breeds')->insert([
            'breed_name' => "Can't find it?",
            'type' => 'other',
        ]);


        foreach ($dogBreeds as $breed) {
            DB::table('breeds')->insert([
                'breed_name' => $breed,
                'type' => 'dog'
            ]);
        }

        foreach ($catBreeds as $breed) {
            DB::table('breeds')->insert([
                'breed_name' => $breed,
                'type' => 'cat'
            ]);
        }
    }
}
