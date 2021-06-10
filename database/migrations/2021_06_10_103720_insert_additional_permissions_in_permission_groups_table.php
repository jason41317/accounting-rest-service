<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertAdditionalPermissionsInPermissionGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permission_groups')->insert([
            ['id' => 23, 'name' => 'Billing Period Management', 'description' => ''],
            ['id' => 24, 'name' => 'Credit Memo Management', 'description' => ''],
            ['id' => 25, 'name' => 'Tax Fund Management', 'description' => '']
        ]);

        DB::table('permissions')->insert([
            ['id' => 221, 'name' => 'Add Billing Period', 'description' => 'Enable feature for adding new Billing Period.', 'permission_group_id' => 23],
            ['id' => 222, 'name' => 'Edit Billing Period', 'description' => 'Enable feature for editing Billing Period.', 'permission_group_id' => 23],
            ['id' => 231, 'name' => 'Add Billing Period', 'description' => 'Enable feature for adding new Credit Memo.', 'permission_group_id' => 24],
            ['id' => 232, 'name' => 'Edit Billing Period', 'description' => 'Enable feature for editing Credit Memo.', 'permission_group_id' => 24],
            ['id' => 233, 'name' => 'Delete Billing Period', 'description' => 'Enable feature for deleting Credit Memo.', 'permission_group_id' => 24],
            ['id' => 241, 'name' => 'Add Tax Fund', 'description' => 'Enable feature for adding new Tax Fund.', 'permission_group_id' => 25],
            ['id' => 54, 'name' => 'Change Contract Assignee', 'description' => 'Enable feature for changing Contract Assignee.', 'permission_group_id' => 6],
        ]);
    }
}
