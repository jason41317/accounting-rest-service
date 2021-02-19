<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('billing_id')->nullable();
            $table->foreign('billing_id')->references('id')->on('billings');
            $table->unsignedBigInteger('charge_id')->nullable();
            $table->foreign('charge_id')->references('id')->on('charges');
            $table->text('notes')->nullable();
            $table->decimal('amount', 15, 5)->default(0)->nullable();
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
        Schema::dropIfExists('billing_charges');
    }
}
