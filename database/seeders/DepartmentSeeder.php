<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'ICT Office',
            'Admin Office',
            'Governors Office',
            'Treasurer Office',
            'Accounting Office',
            'Sangguniang Panlalawigan',
            'Engineering Office',
            'General Supplies Office',
            'Agricultural Office',
            'Environmental Office',
            'Human Resources Office',
            'Budget Office',
            'Economics Office',
            'Tourism Office',
            'Legal Office',
            'Bidding and Acquisition Office',
        ];

        foreach($departments as $department)
        {
            Department::create([
                'office_name' => $department,
            ]);
        }
    }
}
