<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_groups')->insert([
            ['id' => 1, 'name' => 'Approval Management', 'description' => ''],
            ['id' => 2, 'name' => 'Billing Management', 'description' => ''],
            ['id' => 3, 'name' => 'Payment Management', 'description' => ''],
            ['id' => 4, 'name' => 'Disbursement Management', 'description' => ''],
            ['id' => 5, 'name' => 'Client Management', 'description' => ''],
            ['id' => 6, 'name' => 'Contract Management', 'description' => ''],
            ['id' => 7, 'name' => 'Service Category Management', 'description' => ''],
            ['id' => 8, 'name' => 'Service Management', 'description' => ''],
            ['id' => 9, 'name' => 'Document Type Management', 'description' => ''],
            ['id' => 10, 'name' => 'Business Style Management', 'description' => ''],
            ['id' => 11, 'name' => 'Business Type Management', 'description' => ''],
            ['id' => 12, 'name' => 'Account Type Management', 'description' => ''],
            ['id' => 13, 'name' => 'Account Class Management', 'description' => ''],
            ['id' => 14, 'name' => 'Account Title Management', 'description' => ''],
            ['id' => 15, 'name' => 'Charge Management', 'description' => ''],
            ['id' => 16, 'name' => 'RDO Management', 'description' => ''],
            ['id' => 17, 'name' => 'Location Management', 'description' => ''],
            ['id' => 18, 'name' => 'Tax Type Management', 'description' => ''],
            ['id' => 19, 'name' => 'Personnel Management', 'description' => ''],
            ['id' => 20, 'name' => 'User Group Management', 'description' => ''],
        ]);
    }
}
