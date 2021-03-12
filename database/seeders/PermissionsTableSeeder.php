<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            ['id' => 1, 'name' => 'Approve Contract', 'description' => 'Enable feature for approving Contract.', 'permission_group_id' => 1],
            ['id' => 2, 'name' => 'Approve Disbursement', 'description' => 'Enable feature for approving Disbursement.', 'permission_group_id' => 1],
            ['id' => 3, 'name' => 'Approve Collection', 'description' => 'Enable feature for approving Collection.', 'permission_group_id' => 1],
        ]);

        DB::table('permissions')->insert([
            ['id' => 11, 'name' => 'Add Billing', 'description' => 'Enable feature for adding new Billing.', 'permission_group_id' => 2],
            ['id' => 12, 'name' => 'Edit Billing', 'description' => 'Enable feature for editing Billing.', 'permission_group_id' => 2],
            ['id' => 13, 'name' => 'Delete Billing', 'description' => 'Enable feature for deleting Billing.', 'permission_group_id' => 2],
        ]);

        DB::table('permissions')->insert([
            ['id' => 21, 'name' => 'Add Payment', 'description' => 'Enable feature for adding new Payment.', 'permission_group_id' => 3],
            ['id' => 22, 'name' => 'Cancel Payment', 'description' => 'Enable feature for cancelling Payment.', 'permission_group_id' => 3],
        ]);

        DB::table('permissions')->insert([
            ['id' => 31, 'name' => 'Add Disbursement', 'description' => 'Enable feature for adding new Disbursement.', 'permission_group_id' => 4],
            ['id' => 32, 'name' => 'Edit Disbursement', 'description' => 'Enable feature for editing Disbursement.', 'permission_group_id' => 4],
            ['id' => 33, 'name' => 'Delete Disbursement', 'description' => 'Enable feature for deleting Disbursement.', 'permission_group_id' => 4],
        ]);

        DB::table('permissions')->insert([
            ['id' => 41, 'name' => 'Add Client', 'description' => 'Enable feature for adding new Client.', 'permission_group_id' => 5],
            ['id' => 42, 'name' => 'Edit Client', 'description' => 'Enable feature for editing Client.', 'permission_group_id' => 5],
            ['id' => 43, 'name' => 'Delete Client', 'description' => 'Enable feature for deleting Client.', 'permission_group_id' => 5],
        ]);

        DB::table('permissions')->insert([
            ['id' => 51, 'name' => 'Add Contract', 'description' => 'Enable feature for adding new Contract.', 'permission_group_id' => 6],
            ['id' => 52, 'name' => 'Edit Contract', 'description' => 'Enable feature for editing Contract.', 'permission_group_id' => 6],
            ['id' => 53, 'name' => 'Delete Contract', 'description' => 'Enable feature for deleting Contract.', 'permission_group_id' => 6],
        ]);

        DB::table('permissions')->insert([
            ['id' => 61, 'name' => 'Add Service Category', 'description' => 'Enable feature for adding new Service Category.', 'permission_group_id' => 7],
            ['id' => 62, 'name' => 'Edit Service Category', 'description' => 'Enable feature for editing Service Category.', 'permission_group_id' => 7],
            ['id' => 63, 'name' => 'Delete Service Category', 'description' => 'Enable feature for deleting Service Category.', 'permission_group_id' => 7],
        ]);

        DB::table('permissions')->insert([
            ['id' => 71, 'name' => 'Add Service', 'description' => 'Enable feature for adding new Service.', 'permission_group_id' => 8],
            ['id' => 72, 'name' => 'Edit Service', 'description' => 'Enable feature for editing Service.', 'permission_group_id' => 8],
            ['id' => 73, 'name' => 'Delete Service', 'description' => 'Enable feature for deleting Service.', 'permission_group_id' => 8]
        ]);

        DB::table('permissions')->insert([
            ['id' => 81, 'name' => 'Add Document Type', 'description' => 'Enable feature for adding new Document Type.', 'permission_group_id' => 9],
            ['id' => 82, 'name' => 'Edit Document Type', 'description' => 'Enable feature for editing Document Type.', 'permission_group_id' => 9],
            ['id' => 83, 'name' => 'Delete Document Type', 'description' => 'Enable feature for deleting Document Type.', 'permission_group_id' => 9],
        ]);

        DB::table('permissions')->insert([
            ['id' => 91, 'name' => 'Add Business Style', 'description' => 'Enable feature for adding new Business Style.', 'permission_group_id' => 10],
            ['id' => 92, 'name' => 'Edit Business Style', 'description' => 'Enable feature for editing Business Style.', 'permission_group_id' => 10],
            ['id' => 93, 'name' => 'Delete Business Style', 'description' => 'Enable feature for deleting Business Style.', 'permission_group_id' => 10],
        ]);

        DB::table('permissions')->insert([
            ['id' => 101, 'name' => 'Add Business Type', 'description' => 'Enable feature for adding new Business Type.', 'permission_group_id' => 11],
            ['id' => 102, 'name' => 'Edit Business Type', 'description' => 'Enable feature for editing Business Type.', 'permission_group_id' => 11],
            ['id' => 103, 'name' => 'Delete Business Type', 'description' => 'Enable feature for deleting Business Type.', 'permission_group_id' => 11],
        ]);

        DB::table('permissions')->insert([
            ['id' => 111, 'name' => 'Add Account Type', 'description' => 'Enable feature for adding new Account Type.', 'permission_group_id' => 12],
            ['id' => 112, 'name' => 'Edit Account Type', 'description' => 'Enable feature for editing Account Type.', 'permission_group_id' => 12],
            ['id' => 113, 'name' => 'Delete Account Type', 'description' => 'Enable feature for deleting Account Type.', 'permission_group_id' => 12],
        ]);

        DB::table('permissions')->insert([
            ['id' => 121, 'name' => 'Add Account Class', 'description' => 'Enable feature for adding new Account Class.', 'permission_group_id' => 13],
            ['id' => 122, 'name' => 'Edit Account Class', 'description' => 'Enable feature for editing Account Class.', 'permission_group_id' => 13],
            ['id' => 123, 'name' => 'Delete Account Class', 'description' => 'Enable feature for deleting Account Class.', 'permission_group_id' => 13],
        ]);

        DB::table('permissions')->insert([
            ['id' => 131, 'name' => 'Add Account Title', 'description' => 'Enable feature for adding new Account Title.', 'permission_group_id' => 14],
            ['id' => 132, 'name' => 'Edit Account Title', 'description' => 'Enable feature for editing Account Title.', 'permission_group_id' => 14],
            ['id' => 133, 'name' => 'Delete Account Title', 'description' => 'Enable feature for deleting Account Title.', 'permission_group_id' => 14],
        ]);

        DB::table('permissions')->insert([
            ['id' => 141, 'name' => 'Add Charge', 'description' => 'Enable feature for adding new Charge.', 'permission_group_id' => 15],
            ['id' => 142, 'name' => 'Edit Charge', 'description' => 'Enable feature for editing Charge.', 'permission_group_id' => 15],
            ['id' => 143, 'name' => 'Delete Charge', 'description' => 'Enable feature for deleting Charge.', 'permission_group_id' => 15],
        ]);

        DB::table('permissions')->insert([
            ['id' => 151, 'name' => 'Add RDO', 'description' => 'Enable feature for adding new RDO.', 'permission_group_id' => 16],
            ['id' => 152, 'name' => 'Edit RDO', 'description' => 'Enable feature for editing RDO.', 'permission_group_id' => 16],
            ['id' => 153, 'name' => 'Delete RDO', 'description' => 'Enable feature for deleting RDO.', 'permission_group_id' => 16],
        ]);

        DB::table('permissions')->insert([
            ['id' => 161, 'name' => 'Add Location', 'description' => 'Enable feature for adding new Location.', 'permission_group_id' => 17],
            ['id' => 162, 'name' => 'Edit Location', 'description' => 'Enable feature for editing Location.', 'permission_group_id' => 17],
            ['id' => 163, 'name' => 'Delete Location', 'description' => 'Enable feature for deleting Location.', 'permission_group_id' => 17],
        ]);

        DB::table('permissions')->insert([
            ['id' => 171, 'name' => 'Add Tax Type', 'description' => 'Enable feature for adding new Tax Type.', 'permission_group_id' => 18],
            ['id' => 172, 'name' => 'Edit Tax Type', 'description' => 'Enable feature for editing Tax Type.', 'permission_group_id' => 18],
            ['id' => 173, 'name' => 'Delete Tax Type', 'description' => 'Enable feature for deleting Tax Type.', 'permission_group_id' => 18],
        ]);

        DB::table('permissions')->insert([
            ['id' => 181, 'name' => 'Add Personnel', 'description' => 'Enable feature for adding new Personnel.', 'permission_group_id' => 19],
            ['id' => 182, 'name' => 'Edit Personnel', 'description' => 'Enable feature for editing Personnel.', 'permission_group_id' => 19],
            ['id' => 183, 'name' => 'Delete Personnel', 'description' => 'Enable feature for deleting Personnel.', 'permission_group_id' => 19],
        ]);

        DB::table('permissions')->insert([
            ['id' => 191, 'name' => 'Add User Group', 'description' => 'Enable feature for adding new User Group.', 'permission_group_id' => 20],
            ['id' => 192, 'name' => 'Edit User Group', 'description' => 'Enable feature for editing User Group.', 'permission_group_id' => 20],
            ['id' => 193, 'name' => 'Delete User Group', 'description' => 'Enable feature for deleting User Group.', 'permission_group_id' => 20],
        ]);
    }
}
