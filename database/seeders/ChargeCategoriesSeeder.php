<?php

namespace Database\Seeders;

use App\Models\ChargeCategory;
use Illuminate\Database\Seeder;

class ChargeCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $chargeCategories = [
            ['name' => "Retainer's Fee", 'description' => "Retainer's Fee"],
            ['name' => "Filing", 'description' => "Filing"],
            ['name' => "Remittance", 'description' => "Remittance"],
            ['name' => "Others", 'description' => "Others"]
        ];

        foreach ($chargeCategories as $chargeCategory) {
            ChargeCategory::create($chargeCategory);
        }
    }
}
