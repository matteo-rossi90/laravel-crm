<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $employees = [
            [
                'name' => 'John',
                'lastname' => 'Doe',
                'phone_number' => '+1234567890',
                'email' => 'john.doe@example.com',
            ],
            [
                'name' => 'Jane',
                'lastname' => 'Smith',
                'phone_number' => '+1234567891',
                'email' => 'jane.smith@example.com',
            ],
            [
                'name' => 'Michael',
                'lastname' => 'Brown',
                'phone_number' => '0861237891',
                'email' => 'michael.brown@example.com',
            ],
            [
                'name' => 'Helena',
                'lastname' => 'Nathan',
                'phone_number' => '0891345623',
                'email' => 'helena.nathan@example.com',
            ],
            [
                'name' => 'Charles',
                'lastname' => 'Blanchett',
                'phone_number' => '0812126780',
                'email' => 'charles.blanchett@example.com',
            ],
            [
                'name' => 'Adam',
                'lastname' => 'Browny',
                'phone_number' => '0845672891',
                'email' => 'adam.browny@example.com',
            ],
            [
                'name' => 'Darius',
                'lastname' => 'Callaghan',
                'phone_number' => '0822245610',
                'email' => 'darius.callaghan@example.com',
            ],
            [
                'name' => 'Mary',
                'lastname' => 'Boomer',
                'phone_number' => '0765787812',
                'email' => 'mary.boomer@example.com',
            ],
            [
                'name' => 'Ann',
                'lastname' => 'Summerset',
                'phone_number' => '094569124',
                'email' => 'ann.summerset@example.com',
            ],
            [
                'name' => 'Mark',
                'lastname' => 'Andersen',
                'phone_number' => '017873451',
                'email' => 'mark.andersen@example.com',
            ],
        ];

        foreach($employees as $employee){


            $new_employee = new Employee();
            $new_employee->name = $employee['name'];
            $new_employee->company_id = Company::inRandomOrder()->first()->id;
            $new_employee->lastname = $employee['lastname'];
            $new_employee->phone_number = $employee['phone_number'];
            $new_employee->email = $employee['email'];

            $new_employee->save();
        }
    }
}
