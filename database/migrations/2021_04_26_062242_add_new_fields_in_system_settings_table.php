<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsInSystemSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('system_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('service_income_account_class_id')->nullable()->after('accounts_receivable_account_title_id');
            $table->foreign('service_income_account_class_id')->references('id')->on('account_classes');
            $table->unsignedBigInteger('other_income_account_class_id')->nullable()->after('service_income_account_class_id');
            $table->foreign('other_income_account_class_id')->references('id')->on('account_classes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('system_settings', function (Blueprint $table) {
            $table->dropForeign(['service_income_account_class_id']);
            $table->dropColumn('service_income_account_class_id');
            $table->dropForeign(['other_income_account_class_id']);
            $table->dropColumn('other_income_account_class_id');
        });
    }
}
