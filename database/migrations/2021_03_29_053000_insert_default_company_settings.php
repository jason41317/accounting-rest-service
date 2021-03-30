<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertDefaultCompanySettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('company_settings')->insert(
            [
               'id' => 1,
               'company_name' => 'JDEV OFFICE SOLUTION',
               'complete_address' => 'Angeles City, Pampanga',
               'contact_no' => '0912-345-6789',
               'email' => 'jdevtechsolution@gmail.com',
               'billing_cutoff_day' => 10
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
