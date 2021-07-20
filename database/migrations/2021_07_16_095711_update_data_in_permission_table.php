<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateDataInPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permissions')->where('id', 4)->update(['sort_key' => 1]);
        DB::table('permissions')->where('id', 1)->update(['sort_key' => 2]);
        DB::table('permissions')->where('id', 2)->update(['sort_key' => 3, 'deleted_at' => Carbon::now()]);
        DB::table('permissions')->where('id', 5)->update(['sort_key' => 4]);
        DB::table('permissions')->where('id', 3)->update(['sort_key' => 5]);
        DB::table('permissions')->where('id', 14)->update(['sort_key' => 6]);
        DB::table('permissions')->where('id', 11)->update(['sort_key' => 7]);
        DB::table('permissions')->where('id', 12)->update(['sort_key' => 8]);
        DB::table('permissions')->where('id', 13)->update(['sort_key' => 9]);
        DB::table('permissions')->where('id', 23)->update(['sort_key' => 10]);
        DB::table('permissions')->where('id', 21)->update(['sort_key' => 11]);
        DB::table('permissions')->where('id', 22)->update(['sort_key' => 12]);
        DB::table('permissions')->where('id', 34)->update(['sort_key' => 13]);
        DB::table('permissions')->where('id', 31)->update(['sort_key' => 14]);
        DB::table('permissions')->where('id', 32)->update(['sort_key' => 15]);
        DB::table('permissions')->where('id', 33)->update(['sort_key' => 16]);
        DB::table('permissions')->where('id', 44)->update(['sort_key' => 17]);
        DB::table('permissions')->where('id', 41)->update(['sort_key' => 18]);
        DB::table('permissions')->where('id', 42)->update(['sort_key' => 19]);
        DB::table('permissions')->where('id', 43)->update(['sort_key' => 20]);
        DB::table('permissions')->where('id', 55)->update(['sort_key' => 21]);
        DB::table('permissions')->where('id', 51)->update(['sort_key' => 22]);
        DB::table('permissions')->where('id', 52)->update(['sort_key' => 23]);
        DB::table('permissions')->where('id', 53)->update(['sort_key' => 24]);
        DB::table('permissions')->where('id', 54)->update(['sort_key' => 25]);
        DB::table('permissions')->where('id', 64)->update(['sort_key' => 26]);
        DB::table('permissions')->where('id', 61)->update(['sort_key' => 27]);
        DB::table('permissions')->where('id', 62)->update(['sort_key' => 28]);
        DB::table('permissions')->where('id', 63)->update(['sort_key' => 29]);
        DB::table('permissions')->where('id', 74)->update(['sort_key' => 30]);
        DB::table('permissions')->where('id', 71)->update(['sort_key' => 31]);
        DB::table('permissions')->where('id', 72)->update(['sort_key' => 32]);
        DB::table('permissions')->where('id', 73)->update(['sort_key' => 33]);
        DB::table('permissions')->where('id', 84)->update(['sort_key' => 34]);
        DB::table('permissions')->where('id', 81)->update(['sort_key' => 35]);
        DB::table('permissions')->where('id', 82)->update(['sort_key' => 36]);
        DB::table('permissions')->where('id', 83)->update(['sort_key' => 37]);
        DB::table('permissions')->where('id', 94)->update(['sort_key' => 38]);
        DB::table('permissions')->where('id', 91)->update(['sort_key' => 39]);
        DB::table('permissions')->where('id', 92)->update(['sort_key' => 40]);
        DB::table('permissions')->where('id', 93)->update(['sort_key' => 41]);
        DB::table('permissions')->where('id', 104)->update(['sort_key' => 42]);
        DB::table('permissions')->where('id', 101)->update(['sort_key' => 43]);
        DB::table('permissions')->where('id', 102)->update(['sort_key' => 44]);
        DB::table('permissions')->where('id', 103)->update(['sort_key' => 45]);
        DB::table('permissions')->where('id', 114)->update(['sort_key' => 46]);
        DB::table('permissions')->where('id', 111)->update(['sort_key' => 47]);
        DB::table('permissions')->where('id', 112)->update(['sort_key' => 48]);
        DB::table('permissions')->where('id', 113)->update(['sort_key' => 49]);
        DB::table('permissions')->where('id', 124)->update(['sort_key' => 50]);
        DB::table('permissions')->where('id', 121)->update(['sort_key' => 51]);
        DB::table('permissions')->where('id', 122)->update(['sort_key' => 52]);
        DB::table('permissions')->where('id', 123)->update(['sort_key' => 53]);
        DB::table('permissions')->where('id', 134)->update(['sort_key' => 54]);
        DB::table('permissions')->where('id', 131)->update(['sort_key' => 55]);
        DB::table('permissions')->where('id', 132)->update(['sort_key' => 56]);
        DB::table('permissions')->where('id', 133)->update(['sort_key' => 57]);
        DB::table('permissions')->where('id', 144)->update(['sort_key' => 58]);
        DB::table('permissions')->where('id', 141)->update(['sort_key' => 59]);
        DB::table('permissions')->where('id', 142)->update(['sort_key' => 60]);
        DB::table('permissions')->where('id', 143)->update(['sort_key' => 61]);
        DB::table('permissions')->where('id', 154)->update(['sort_key' => 62]);
        DB::table('permissions')->where('id', 151)->update(['sort_key' => 63]);
        DB::table('permissions')->where('id', 152)->update(['sort_key' => 64]);
        DB::table('permissions')->where('id', 153)->update(['sort_key' => 65]);
        DB::table('permissions')->where('id', 164)->update(['sort_key' => 66]);
        DB::table('permissions')->where('id', 161)->update(['sort_key' => 67]);
        DB::table('permissions')->where('id', 162)->update(['sort_key' => 68]);
        DB::table('permissions')->where('id', 163)->update(['sort_key' => 69]);
        DB::table('permissions')->where('id', 174)->update(['sort_key' => 70]);
        DB::table('permissions')->where('id', 171)->update(['sort_key' => 71]);
        DB::table('permissions')->where('id', 172)->update(['sort_key' => 72]);
        DB::table('permissions')->where('id', 173)->update(['sort_key' => 73]);
        DB::table('permissions')->where('id', 184)->update(['sort_key' => 74]);
        DB::table('permissions')->where('id', 181)->update(['sort_key' => 75]);
        DB::table('permissions')->where('id', 182)->update(['sort_key' => 76]);
        DB::table('permissions')->where('id', 183)->update(['sort_key' => 77]);
        DB::table('permissions')->where('id', 194)->update(['sort_key' => 78]);
        DB::table('permissions')->where('id', 191)->update(['sort_key' => 79]);
        DB::table('permissions')->where('id', 192)->update(['sort_key' => 80]);
        DB::table('permissions')->where('id', 193)->update(['sort_key' => 81]);
        DB::table('permissions')->where('id', 204)->update(['sort_key' => 82]);
        DB::table('permissions')->where('id', 201)->update(['sort_key' => 83]);
        DB::table('permissions')->where('id', 202)->update(['sort_key' => 84]);
        DB::table('permissions')->where('id', 203)->update(['sort_key' => 85]);
        DB::table('permissions')->where('id', 214)->update(['sort_key' => 86]);
        DB::table('permissions')->where('id', 211)->update(['sort_key' => 87]);
        DB::table('permissions')->where('id', 212)->update(['sort_key' => 88]);
        DB::table('permissions')->where('id', 213)->update(['sort_key' => 89]);
        DB::table('permissions')->where('id', 223)->update(['sort_key' => 90]);
        DB::table('permissions')->where('id', 221)->update(['sort_key' => 91]);
        DB::table('permissions')->where('id', 222)->update(['sort_key' => 92]);
        DB::table('permissions')->where('id', 234)->update(['sort_key' => 93]);
        DB::table('permissions')->where('id', 231)->update(['sort_key' => 94]);
        DB::table('permissions')->where('id', 232)->update(['sort_key' => 95]);
        DB::table('permissions')->where('id', 233)->update(['sort_key' => 96]);
        DB::table('permissions')->where('id', 242)->update(['sort_key' => 97]);
        DB::table('permissions')->where('id', 241)->update(['sort_key' => 98]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permission', function (Blueprint $table) {
            //
        });
    }
}
