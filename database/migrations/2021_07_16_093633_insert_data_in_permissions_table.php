<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertDataInPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // add new permissions for viewing
        DB::table('permissions')->insert([
            ['id' => 4, 'name' => 'View Contracts', 'description' => 'Enable feature for viewing contract for approval.', 'permission_group_id' => 1],
            ['id' => 5, 'name' => 'View Collection', 'description' => 'Enable feature for viewing collection for approval.', 'permission_group_id' => 1],
            ['id' => 14, 'name' => 'View Billing', 'description' => 'Enable feature for viewing billing.', 'permission_group_id' => 2],
            ['id' => 23, 'name' => 'View Payment', 'description' => 'Enable feature for viewing payment.', 'permission_group_id' => 3],
            ['id' => 34, 'name' => 'View Disbursement', 'description' => 'Enable feature for viewing disbursement.', 'permission_group_id' => 4],
            ['id' => 44, 'name' => 'View Client', 'description' => 'Enable feature for viewing client.', 'permission_group_id' => 5],
            ['id' => 55, 'name' => 'View Contract', 'description' => 'Enable feature for viewing contract.', 'permission_group_id' => 6],
            ['id' => 64, 'name' => 'View Service Category', 'description' => 'Enable feature for viewing service category.', 'permission_group_id' => 7],
            ['id' => 74, 'name' => 'View Service', 'description' => 'Enable feature for viewing contract.', 'permission_group_id' => 8],
            ['id' => 84, 'name' => 'View Document Type', 'description' => 'Enable feature for viewing contract.', 'permission_group_id' => 9],
            ['id' => 94, 'name' => 'View Business Style', 'description' => 'Enable feature for viewing contract.', 'permission_group_id' => 10],
            ['id' => 104, 'name' => 'View Business Type', 'description' => 'Enable feature for viewing contract.', 'permission_group_id' => 11],
            ['id' => 114, 'name' => 'View Account Type', 'description' => 'Enable feature for viewing contract.', 'permission_group_id' => 12],
            ['id' => 124, 'name' => 'View Account Class', 'description' => 'Enable feature for viewing contract.', 'permission_group_id' => 13],
            ['id' => 134, 'name' => 'View Account Title', 'description' => 'Enable feature for viewing contract.', 'permission_group_id' => 14],
            ['id' => 144, 'name' => 'View Charge', 'description' => 'Enable feature for viewing contract.', 'permission_group_id' => 15],
            ['id' => 154, 'name' => 'View RDO', 'description' => 'Enable feature for viewing contract.', 'permission_group_id' => 16],
            ['id' => 164, 'name' => 'View Location', 'description' => 'Enable feature for viewing contract.', 'permission_group_id' => 17],
            ['id' => 174, 'name' => 'View Tax Type', 'description' => 'Enable feature for viewing contract.', 'permission_group_id' => 18],
            ['id' => 184, 'name' => 'View Personnel', 'description' => 'Enable feature for viewing contract.', 'permission_group_id' => 19],
            ['id' => 194, 'name' => 'View User Group', 'description' => 'Enable feature for viewing contract.', 'permission_group_id' => 20],
            ['id' => 204, 'name' => 'View Bank', 'description' => 'Enable feature for viewing contract.', 'permission_group_id' => 21],
            ['id' => 214, 'name' => 'View EWallet', 'description' => 'Enable feature for viewing contract.', 'permission_group_id' => 22],
            ['id' => 223, 'name' => 'View Billing Period', 'description' => 'Enable feature for viewing contract.', 'permission_group_id' => 23],
            ['id' => 234, 'name' => 'View Credit Memo', 'description' => 'Enable feature for viewing contract.', 'permission_group_id' => 24],
            ['id' => 242, 'name' => 'View Tax Fund', 'description' => 'Enable feature for viewing contract.', 'permission_group_id' => 25],
        ]);
        //update permission
        DB::table('permissions')->where('id', 231)->update(['name' => 'Add Credit Memo']);
        DB::table('permissions')->where('id', 232)->update(['name' => 'Edit Credit Memo']);
        DB::table('permissions')->where('id', 233)->update(['name' => 'Delete Credit Memo']);
    }
}
