<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_titles', function (Blueprint $table) {
            $table->id();
            $table->string('code')->default('')->nullable();
            $table->string('name')->default('')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('account_class_id')->nullable();
            $table->foreign('account_class_id')->references('id')->on('account_classes');
            $table->unsignedBigInteger('parent_account_id')->nullable();
            $table->foreign('parent_account_id')->references('id')->on('account_titles');
            $table->unsignedBigInteger('grand_parent_account_id')->nullable();
            $table->foreign('grand_parent_account_id')->references('id')->on('account_titles');
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
        Schema::dropIfExists('account_titles');
    }
}
