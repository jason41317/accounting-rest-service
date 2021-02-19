<?php

namespace Database\Seeders;

use App\Models\AccountType;
use App\Models\Month;
use App\Models\Personnel;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'personnel' => [
                    'name' => 'Admin',
                    'first_name' => 'JDEV',
                    'last_name' => 'Office'
                ],
                'account' => [
                    'username' => 'admin@jdev.com',
                    'password' => bcrypt('password')
                ]
            ]
        ];

        foreach ($users as $user) {
            $personnel = Personnel::create($user['personnel']);
            $personnel->user()->create($user['account']);
        }

        $accountTypes = [
            ['name' => 'Asset'],
            ['name' => 'Liability'],
            ['name' => 'Capital'],
            ['name' => 'Income'],
            ['name' => 'Expense']
        ];

        foreach ($accountTypes as $accountType) {
            AccountType::create($accountType);
        }

        $months = [
            ['name' => 'January'],
            ['name' => 'February'],
            ['name' => 'March'],
            ['name' => 'April'],
            ['name' => 'May'],
            ['name' => 'June'],
            ['name' => 'July'],
            ['name' => 'August'],
            ['name' => 'September'],
            ['name' => 'October'],
            ['name' => 'November'],
            ['name' => 'December']
        ];

        foreach ($months as $month) {
            Month::create($month);
        }
    }
}
