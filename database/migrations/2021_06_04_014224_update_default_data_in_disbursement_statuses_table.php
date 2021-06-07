<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDefaultDataInDisbursementStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('disbursement_statuses')->where('id', 1)
        ->update(['name' => 'For Printing']);
        DB::table('disbursement_statuses')->where('id', 2)
        ->update(['name' => 'Printed']);
        DB::table('disbursement_statuses')->where('id', 3)
        ->update(['name' => 'Cancelled']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('disbursement_statuses', function (Blueprint $table) {
            //
        });
    }
}
