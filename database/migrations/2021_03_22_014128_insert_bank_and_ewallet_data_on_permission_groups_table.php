<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertBankAndEwalletDataOnPermissionGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         DB::table('permission_groups')->insert([
            ['id' => 21, 'name' => 'Bank Management', 'description' => ''],
            ['id' => 22, 'name' => 'E-Wallet Management', 'description' => '']
         ]);

        DB::table('permissions')->insert([
            ['id' => 201, 'name' => 'Add Bank', 'description' => 'Enable feature for adding new Bank.', 'permission_group_id' => 21],
            ['id' => 202, 'name' => 'Edit Bank', 'description' => 'Enable feature for editing Bank.', 'permission_group_id' => 21],
            ['id' => 203, 'name' => 'Delete Bank', 'description' => 'Enable feature for deleting Bank.', 'permission_group_id' => 21],
        ]);

        DB::table('permissions')->insert([
            ['id' => 211, 'name' => 'Add E-Wallet', 'description' => 'Enable feature for adding new E-Wallet.', 'permission_group_id' => 22],
            ['id' => 212, 'name' => 'Edit E-Wallet', 'description' => 'Enable feature for editing E-Wallet.', 'permission_group_id' => 22],
            ['id' => 213, 'name' => 'Delete E-Wallet', 'description' => 'Enable feature for deleting E-Wallet.', 'permission_group_id' => 22],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
