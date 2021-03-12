<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ApprovalFieldsContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dateTime('approved_at')->after('contract_status_id')->nullable();
            $table->text('approved_notes')->after('contract_status_id')->nullable();

            $table->unsignedBigInteger('approved_by')->after('contract_status_id')->nullable();
            $table->foreign('approved_by')->references('id')->on('personnels');

            $table->unsignedBigInteger('assigned_to')->after('contract_status_id')->nullable();
            $table->foreign('assigned_to')->references('id')->on('personnels');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->dropForeign(['approved_by', 'assigned_to']);
            $table->dropColumn(['approved_notes', 'approved_at', 'assigned_to', 'approved_by']);
        });
    }
}
