<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArAccountIdOnCompanySettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('ar_account_id')->after('billing_cutoff_day')->default(null)->nullable();
            $table->foreign('ar_account_id')->references('id')->on('account_titles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company_settings', function (Blueprint $table) {
            $table->dropForeign(['ar_account_id']);
            $table->dropColumn(['ar_account_id']);
        });
    }
}
