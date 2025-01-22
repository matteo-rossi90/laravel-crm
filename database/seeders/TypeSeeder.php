<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [

            'Technology and Software Development',
            'Healthcare',
            'Banking',
            'Education',
            'Retail and E-Commerce',
            'Real Estate',
            'Food and Beverage Industry',
            'Manufacturing and Production',
            'Transportation',
            'Marketing and Advertising'
        ];

        foreach($types as $type){

            $new_type = new Type();
            $new_type->name = $type;
            $new_type->save();
        }
    }
}
