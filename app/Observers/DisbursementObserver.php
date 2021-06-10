<?php

namespace App\Observers;

use Carbon\Carbon;
use App\Models\Disbursement;
use App\Services\JournalEntryService;
use Illuminate\Support\Facades\Auth;

class DisbursementObserver
{
    /**
     * Handle the Disbursement "creating" event.
     *
     * @param  \App\Models\Disbursement  $disbursement
     * @return void
     */
    public function creating(Disbursement $disbursement)
    {
        // $approvedStatusId = 2;
        //insert on journal entry
        $count = Disbursement::count() + 1;
        $disbursement->voucher_no = 'VN-' . date('Ym') . '-' . str_pad($count, 6, '0', STR_PAD_LEFT);
    }
    /**
     * Handle the Disbursement "updated" event.
     *
     * @param  \App\Models\Disbursement  $disbursement
     * @return void
     */
    public function updating(Disbursement $disbursement)
    {
        $cancelledStatusId = 3;

        if($disbursement->disbursement_status_id === $cancelledStatusId) {
            $journalEntry = $disbursement->journalEntry;
            $journalEntryService = new JournalEntryService();
            $journalEntryService->delete($journalEntry->id);
        }
    }
}
