<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertDefaultDisbursementStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('disbursement_statuses')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'Pending'
                ],
                [
                    'id' => 2,
                    'name' => 'Approved'
                ],
                [
                    'id' => 3,
                    'name' => 'Rejected'
                ]
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
