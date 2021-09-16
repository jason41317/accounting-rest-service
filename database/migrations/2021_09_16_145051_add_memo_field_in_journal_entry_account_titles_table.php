<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMemoFieldInJournalEntryAccountTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journal_entry_account_titles', function (Blueprint $table) {
            $table->text('memo')->default('')->after('credit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('journal_entry_account_titles', function (Blueprint $table) {
            $table->dropColumn('memo');
        });
    }
}
