<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyChargeCategoryIdInChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('charges', function (Blueprint $table) {
            $table->unsignedBigInteger('charge_category_id')->nullable()->after('account_title_id');
            $table->foreign('charge_category_id')->references('id')->on('charge_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('charges', function (Blueprint $table) {
            $table->dropForeign(['charge_category_id']);
            $table->dropColumn('charge_category_id');
        });
    }
}
