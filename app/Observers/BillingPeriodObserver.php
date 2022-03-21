<?php

namespace App\Observers;

use App\Models\Billing;
use App\Models\BillingPeriod;
use App\Models\CompanySetting;
use App\Models\SystemSetting;
use App\Services\JournalEntryService;
use Illuminate\Support\Facades\Auth;

class BillingPeriodObserver
{
    /**
     * Handle the Payment "creating" event.
     *
     * @param  \App\Models\ClosedBillingPeriod  $closedBillingPeriod
     * @return void
     */
    public function created(BillingPeriod $billingPeriod)
    {
        $monthId = $billingPeriod->month_id;
        $year = $billingPeriod->year;
        $billings = Billing::whereRaw('DATE(CONCAT(year,"-",month_id,"-",1)) != DATE(CONCAT('.$year.',"-",'.$monthId.',"-",1))')
            ->whereDoesntHave('journalEntry')
            ->get();

        $systemSettings = SystemSetting::find(1);

        foreach ($billings as $billing) {
            $charges = $billing->charges()->get();
            $adjustmentCharges = $billing->adjustmentCharges()->get();
            $accountTitleData = $charges->mergeRecursive($adjustmentCharges)->groupBy('account_title_id');
            $data = [
                'reference_no' => $billing->billing_no,
                'transaction_date' => $billing->billing_date,
                'contract_id' => $billing->contract_id,
                'client_id' => $billing->client_id,
                'total_amount' => $billing->amount,
                'journalable_id' => $billing->id,
                'journalable_type' => 'App\Models\Billing'
            ];
            $accountTitles = [];

            $accountTitles[] = [
                'account_title_id' => $systemSettings->accounts_receivable_account_title_id,
                'debit' => $billing->amount,
                'credit' => 0
            ];

            foreach ($accountTitleData as $key => $value)
            {
                $accountTitles[] = [
                    'account_title_id' => $key,
                    'debit' => 0,
                    'credit' => $value->sum('pivot.amount')
                ];
            }
            
            $journalEntryService = new JournalEntryService();
            $journalEntryService->store($data, $accountTitles);
        }

        $billingPeriod->created_by = Auth::id();
    }
}
