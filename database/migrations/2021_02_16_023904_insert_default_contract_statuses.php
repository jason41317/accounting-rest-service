<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertDefaultContractStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('contract_statuses')->insert([
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
                    'name' => 'Inactive'
                ],
            
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
