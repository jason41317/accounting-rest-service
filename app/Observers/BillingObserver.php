<?php

namespace App\Observers;

use App\Models\Billing;

class BillingObserver
{
    /**
     * Handle the Billing "creating" event.
     *
     * @param  \App\Models\Billing  $billing
     * @return void
     */
    public function creating(Billing $billing)
    {
        $year = $billing->year;
        $month = $billing->month_id;
        $count = Billing::where('year', $year)
        ->where('month_id', $month)
        ->count() + 1;

        $billing->billing_no = 'BN-' . date('Ym', strtotime($year . '-' . $month . '-1')) . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
