<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertReportPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permission_groups')->insert([
            ['id' => 27, 'name' => 'Reports', 'description' => '', 'sort_key' => 27],
        ]);

        DB::table('permissions')->insert([
            ['id' => 251, 'name' => 'Collection Report (Detailed)', 'description' => 'Enable feature for viewing/generating Collection (Detailed) report.', 'permission_group_id' => 27],
            ['id' => 252, 'name' => 'Collection Report (Summary)', 'description' => 'Enable feature for viewing/generating Collection (Summary) report.', 'permission_group_id' => 27],
            ['id' => 253, 'name' => 'Client Subsidiary Report', 'description' => 'Enable feature for viewing/generating Client Subsidiary report.', 'permission_group_id' => 27],
            ['id' => 254, 'name' => 'Account Receivable Report', 'description' => 'Enable feature for viewing/generating Account Receivable report.', 'permission_group_id' => 27],
            ['id' => 255, 'name' => 'Statement of Financial Position Report', 'description' => 'Enable feature for viewing/generating Statement of Financial Position report.', 'permission_group_id' => 27],
            ['id' => 256, 'name' => 'Income Statement Report', 'description' => 'Enable feature for viewing/generating Income Statement report.', 'permission_group_id' => 27],
        ]);
    }
}
