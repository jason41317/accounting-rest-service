<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertDataInPermissionGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permission_groups')->insert([
            ['name' => 'Collection Approval Management', 'sort_key' => 2]
        ]);

        DB::table('permission_groups')->where('id', 1)->update(['sort_key' => '1', 'name' => 'Contract Approval Management']);
        DB::table('permission_groups')->where('id', 2)->update(['sort_key' => '3']);
        DB::table('permission_groups')->where('id', 3)->update(['sort_key' => '4']);
        DB::table('permission_groups')->where('id', 4)->update(['sort_key' => '5']);
        DB::table('permission_groups')->where('id', 5)->update(['sort_key' => '6']);
        DB::table('permission_groups')->where('id', 6)->update(['sort_key' => '7']);
        DB::table('permission_groups')->where('id', 7)->update(['sort_key' => '8']);
        DB::table('permission_groups')->where('id', 8)->update(['sort_key' => '9']);
        DB::table('permission_groups')->where('id', 9)->update(['sort_key' => '10']);
        DB::table('permission_groups')->where('id', 10)->update(['sort_key' => '11']);
        DB::table('permission_groups')->where('id', 11)->update(['sort_key' => '12']);
        DB::table('permission_groups')->where('id', 12)->update(['sort_key' => '13']);
        DB::table('permission_groups')->where('id', 13)->update(['sort_key' => '14']);
        DB::table('permission_groups')->where('id', 14)->update(['sort_key' => '15']);
        DB::table('permission_groups')->where('id', 15)->update(['sort_key' => '16']);
        DB::table('permission_groups')->where('id', 16)->update(['sort_key' => '17']);
        DB::table('permission_groups')->where('id', 17)->update(['sort_key' => '18']);
        DB::table('permission_groups')->where('id', 18)->update(['sort_key' => '19']);
        DB::table('permission_groups')->where('id', 19)->update(['sort_key' => '20']);
        DB::table('permission_groups')->where('id', 20)->update(['sort_key' => '21']);
        DB::table('permission_groups')->where('id', 21)->update(['sort_key' => '22']);
        DB::table('permission_groups')->where('id', 22)->update(['sort_key' => '23']);
        DB::table('permission_groups')->where('id', 23)->update(['sort_key' => '24']);
        DB::table('permission_groups')->where('id', 24)->update(['sort_key' => '25']);
        DB::table('permission_groups')->where('id', 25)->update(['sort_key' => '26']);
    }
}
