<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        for($i = 0; $i < 5; $i++){
            $new_company = new Company();
            $new_company->type_id = Type::inRandomOrder()->first()->id;
            $new_company->name = $faker->randomElement(['TechNova Solutions','GreenField Industries','BlueWave Technologies','EcoSphere Energy','NextGen Innovations']);
            $new_company->VAT = $faker->numerify('##########');
            $new_company->address = $faker->address();
            $new_company->description = $faker->paragraph(8);
            $new_company->logo = $faker->imageUrl(300, 300, 'business', true, 'logo');
            $new_company->save();
        }
    }
}
