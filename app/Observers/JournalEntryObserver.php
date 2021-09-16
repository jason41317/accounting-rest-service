<?php

namespace App\Observers;

use App\Models\JournalEntry;
use App\Services\JournalEntryService;

class JournalEntryObserver
{
    /**
     * Handle the JournalEntry "creating" event.
     *
     * @param  \App\Models\JournalEntry  $billing
     * @return void
     */
    public function creating(JournalEntry $journalEntry)
    {   

        if ($journalEntry->journal_entry_type_id === 4) {
            $journalEntryService = new JournalEntryService();
            $journalEntry->reference_no = $journalEntryService->generalJournalNo();
        }
    }
}
