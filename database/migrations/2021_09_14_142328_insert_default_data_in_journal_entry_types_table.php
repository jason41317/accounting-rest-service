<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InsertDefaultDataInJournalEntryTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('journal_entry_types')->insert([
            ['id' => 1, 'name' => 'Billing', 'description' => 'Billing'],
            ['id' => 2, 'name' => 'Disbursement', 'description' => 'Disbursement'],
            ['id' => 3, 'name' => 'Payment', 'description' => 'Payment'],
            ['id' => 4, 'name' => 'General Journal', 'description' => 'General Journal'],
        ]);

        DB::table('journal_entries')->where('journalable_type', 'App\Models\Billing')->update(['journal_entry_type_id' => 1]);
        DB::table('journal_entries')->where('journalable_type', 'App\Models\Disbursment')->update(['journal_entry_type_id' => 2]);
        DB::table('journal_entries')->where('journalable_type', 'App\Models\Payment')->update(['journal_entry_type_id' => 3]);
    }
}
