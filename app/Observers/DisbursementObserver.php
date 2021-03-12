<?php

namespace App\Observers;

use App\Models\Disbursement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DisbursementObserver
{
    /**
     * Handle the Disbursement "updated" event.
     *
     * @param  \App\Models\Disbursement  $disbursement
     * @return void
     */
    public function updating(Disbursement $disbursement)
    {
        $approvedStatusId = 2;

        if($disbursement->disbursement_status_id === $approvedStatusId) {
            $disbursement->approved_by = Auth::id();
            $disbursement->approved_at = Carbon::now();
        }

        $disbursement->updated_by = Auth::id();
    }
}
