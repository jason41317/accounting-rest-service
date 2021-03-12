<?php

namespace App\Observers;

use Carbon\Carbon;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentObserver
{
    /**
     * Handle the Payment "updated" event.
     *
     * @param  \App\Models\Payment  $payment
     * @return void
     */
    public function updating(Payment $payment)
    {
        $approvedStatusId = 2;

        if($payment->payment_status_id === $approvedStatusId) {
            $payment->approved_by = Auth::id();
            $payment->approved_at = Carbon::now();
        }

        $payment->updated_by = Auth::id();
    }
}
