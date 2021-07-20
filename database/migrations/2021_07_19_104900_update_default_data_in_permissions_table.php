<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateDefaultDataInPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permissions')->where('id', 4)->update(['is_view' => 1]);
        DB::table('permissions')->where('id', 5)->update(['is_view' => 1]);
        DB::table('permissions')->where('id', 14)->update(['is_view' => 1]);
        DB::table('permissions')->where('id', 23)->update(['is_view' => 1]);
        DB::table('permissions')->where('id', 34)->update(['is_view' => 1]);
        DB::table('permissions')->where('id', 44)->update(['is_view' => 1]);
        DB::table('permissions')->where('id', 55)->update(['is_view' => 1]);
        DB::table('permissions')->where('id', 64)->update(['is_view' => 1]);
        DB::table('permissions')->where('id', 74)->update(['is_view' => 1]);
        DB::table('permissions')->where('id', 84)->update(['is_view' => 1]);
        DB::table('permissions')->where('id', 94)->update(['is_view' => 1]);
        DB::table('permissions')->where('id', 104)->update(['is_view' => 1]);
        DB::table('permissions')->where('id', 114)->update(['is_view' => 1]);
        DB::table('permissions')->where('id', 124)->update(['is_view' => 1]);
        DB::table('permissions')->where('id', 134)->update(['is_view' => 1]);
        DB::table('permissions')->where('id', 144)->update(['is_view' => 1]);
        DB::table('permissions')->where('id', 154)->update(['is_view' => 1]);
        DB::table('permissions')->where('id', 164)->update(['is_view' => 1]);
        DB::table('permissions')->where('id', 174)->update(['is_view' => 1]);
        DB::table('permissions')->where('id', 184)->update(['is_view' => 1]);
        DB::table('permissions')->where('id', 194)->update(['is_view' => 1]);
        DB::table('permissions')->where('id', 204)->update(['is_view' => 1]);
        DB::table('permissions')->where('id', 214)->update(['is_view' => 1]);
        DB::table('permissions')->where('id', 223)->update(['is_view' => 1]);
        DB::table('permissions')->where('id', 234)->update(['is_view' => 1]);
        DB::table('permissions')->where('id', 242)->update(['is_view' => 1]);
    }
}
