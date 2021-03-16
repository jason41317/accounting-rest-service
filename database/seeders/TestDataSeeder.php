<?php

namespace Database\Seeders;

use App\Models\Month;
use App\Models\Personnel;
use App\Models\AccountClass;
use Faker\Factory;
use App\Models\User;
use App\Models\Charge;
use App\Models\Service;
use App\Models\AccountType;
use App\Models\AccountTitle;
use App\Models\BusinessType;
use App\Models\DocumentType;
use App\Models\BusinessStyle;
use App\Models\ServiceCategory;
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

        $faker = Factory::create();

        for($i = 0; $i < 5; $i++) {
            AccountClass::create([
                'name' => $faker->text(15),
                'description' => $faker->text(30),
                'account_type_id' => $faker->numberBetween(1,5)
            ]);
        }

        for($i = 0; $i < 20; $i++) {
            AccountTitle::create([
                'code' => $faker->word,
                'name' => $faker->text(15),
                'description' => $faker->text(30),
                'account_class_id' => $faker->numberBetween(1,5)
            ]);
        }

        for($i = 0; $i < 20; $i++) {
            Charge::create([
                'name' => $faker->text(15),
                'description' => $faker->text(25),
                'account_title_id' => $faker->numberBetween(1,20)
            ]);
        }

        for($i = 0; $i < 10; $i++) {
            BusinessType::create([
                'name' => $faker->text(15),
                'description' => $faker->text(25),
            ]);
        }

        for($i = 0; $i < 10; $i++) {
            BusinessStyle::create([
                'name' => $faker->text(15),
                'description' => $faker->text(25),
            ]);
        }

        for($i = 0; $i < 10; $i++) {
            DocumentType::create([
                'name' => $faker->text(15),
                'description' => $faker->text(25),
            ]);
        }

        for($i = 0; $i < 10; $i++) {
            ServiceCategory::create([
                'name' => $faker->text(15),
                'description' => $faker->text(25),
            ]);
        }

        for($i = 0; $i < 20; $i++) {
            Service::create([
                'code' => $faker->word,
                'name' => $faker->text(15),
                'description' => $faker->text(25),
                'service_category_id' => $faker->numberBetween(1,10)
            ]);
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
