<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisbursementDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disbursement_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('disbursement_id')->nullable();
            $table->foreign('disbursement_id')->references('id')->on('disbursements');
            $table->string('particular')->default('')->nullable();
            $table->unsignedBigInteger('account_title_id')->nullable();
            $table->foreign('account_title_id')->references('id')->on('account_titles');
            $table->decimal('amount', 15, 5)->default(0)->nullable();
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
        Schema::dropIfExists('disbursement_details');
    }
}
