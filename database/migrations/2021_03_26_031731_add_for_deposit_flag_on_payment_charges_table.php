<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForDepositFlagOnPaymentChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_charges', function (Blueprint $table) {
            $table->boolean('for_deposit')->default(0)->after('charge_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_charges', function (Blueprint $table) {
            $table->dropColumn('for_deposit');
        });
    }
}
