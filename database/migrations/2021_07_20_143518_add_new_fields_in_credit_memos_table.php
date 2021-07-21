<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsInCreditMemosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credit_memos', function (Blueprint $table) {
            $table->unsignedBigInteger('billing_id')->nullable()->after('credit_memo_date');
            $table->foreign('billing_id')->references('id')->on('billings');
            $table->tinyInteger('is_applied')->default(0)->nullable()->after('billing_id');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('credit_memos', function (Blueprint $table) {
            $table->dropForeign(['billing_id']);
            $table->dropColumn('billing_id');
            $table->dropColumn('is_applied');
        });
    }
}
