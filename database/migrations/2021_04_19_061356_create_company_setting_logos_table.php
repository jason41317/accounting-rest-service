<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanySettingLogosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_setting_logos', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('')->nullable();
            $table->string('path')->default('')->nullable();
            $table->string('hash_name')->default('')->nullable();
            $table->foreign('company_setting_id')->references('id')->on('company_settings');
            $table->unsignedBigInteger('company_setting_id')->nullable();
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
        Schema::dropIfExists('company_setting_logos');
    }
}
