<?php

namespace App\Observers;

use App\Models\Billing;
use App\Models\SystemSetting;
use App\Services\JournalEntryService;

class BillingObserver
{
    /**
     * Handle the Billing "updating" event.
     *
     * @param  \App\Models\Billing  $billing
     * @return void
     */
    public function updating(Billing $billing)
    {
        
    }
}
