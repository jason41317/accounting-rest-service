<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJournalEntryTypeFieldInJournalEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journal_entries', function (Blueprint $table) {
            $table->unsignedBigInteger('journal_entry_type_id')->nullable()->after('journalable_type');
            $table->foreign('journal_entry_type_id')->references('id')->on('journal_entry_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('journal_entries', function (Blueprint $table) {
            $table->dropForeign(['journal_entry_type_id']);
            $table->dropColumn('journal_entry_type_id');
        });
    }
}
