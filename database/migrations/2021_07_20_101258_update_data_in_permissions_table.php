<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateDataInPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permissions')->where('id', 3)->update(['permission_group_id' => 26]);
        DB::table('permissions')->where('id', 5)->update(['permission_group_id' => 26]);
    }
}
