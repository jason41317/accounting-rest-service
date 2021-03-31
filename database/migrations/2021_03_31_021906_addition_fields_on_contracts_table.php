<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdditionFieldsOnContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contracts', function (Blueprint $table) {
            $table->unsignedBigInteger('business_type_id')->after('nature_of_business')->nullable()->default(null);
            $table->foreign('business_type_id')->references('id')->on('business_types');

            $table->unsignedBigInteger('business_style_id')->after('business_type_id')->nullable()->default(null);
            $table->foreign('business_style_id')->references('id')->on('business_styles');

            $table->string('industry')->after('business_style_id')->nullable()->default(null);
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
            //
        });
    }
}
