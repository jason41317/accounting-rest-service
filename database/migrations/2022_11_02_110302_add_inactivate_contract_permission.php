<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInactivateContractPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permissions')->insert([
            ['id' => 56, 'name' => 'Inactivate Contract', 'description' => 'Enable feature for setting contract to inactive status.', 'permission_group_id' => 6, 'sort_key' => 26],
        ]);
    }
}
