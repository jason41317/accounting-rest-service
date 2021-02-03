<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('code')->default('')->nullable();
            $table->string('name')->default('')->nullable();
            $table->string('trade_name')->default('')->nullable();
            $table->text('office_address')->nullable();
            $table->string('owner')->default('')->nullable();
            $table->string('email')->default('')->nullable();
            $table->string('contact_no')->default('')->nullable();
            $table->string('rdo_no')->default('')->nullable();
            // $table->string('tin')->default('')->nullable();
            $table->string('industry')->default('')->nullable();
            $table->string('sec_dti_no')->default('')->nullable();
            $table->unsignedBigInteger('business_type_id')->nullable();
            $table->foreign('business_type_id')->references('id')->on('business_types');
            $table->unsignedBigInteger('business_style_id')->nullable();
            $table->foreign('business_style_id')->references('id')->on('business_styles');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
