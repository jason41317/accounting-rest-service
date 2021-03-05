<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsOnDisbursementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('disbursements', function (Blueprint $table) {
            $table->date('cheque_date')->after('cheque_no')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users');
            $table->dateTime('approved_at')->nullable();
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->foreign('rejected_by')->references('id')->on('users');
            $table->dateTime('rejected_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('disbursements', function (Blueprint $table) {
            $table->dropForeign('approved_by');
            $table->dropColumn('approved_by');
            $table->dropForeign('rejected_by');
            $table->dropColumn('rejected_by');
            $table->dropColumn('approved_at');
            $table->dropColumn('rejected_at');
            $table->dropColumn('cheque_date');
        });
    }
}
