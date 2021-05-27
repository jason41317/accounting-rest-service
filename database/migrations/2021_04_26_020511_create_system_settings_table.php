<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cash_account_title_id')->nullable();
            $table->foreign('cash_account_title_id')->references('id')->on('account_titles');
            $table->unsignedBigInteger('accounts_receivable_account_title_id')->nullable();
            $table->foreign('accounts_receivable_account_title_id')->references('id')->on('account_titles');
            $table->unsignedBigInteger('operating_expense_account_class_id')->nullable();;
            $table->foreign('operating_expense_account_class_id')->references('id')->on('account_classes');
            $table->integer('billing_cutoff_day')->default(null)->nullable();
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
        Schema::dropIfExists('system_settings');
    }
}
