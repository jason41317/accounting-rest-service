<?php

namespace App\Observers;

use App\Models\Billing;
use App\Models\ClosedBillingPeriod;
use App\Models\CompanySetting;
use App\Services\JournalEntryService;
use Illuminate\Support\Facades\Auth;

class ClosedBillingPeriodObserver
{
    /**
     * Handle the Payment "creating" event.
     *
     * @param  \App\Models\ClosedBillingPeriod  $closedBillingPeriod
     * @return void
     */
    public function creating(ClosedBillingPeriod $closedBillingPeriod) 
    {
        $monthId = $closedBillingPeriod->month_id;
        $year = $closedBillingPeriod->year;
        $billings = Billing::where('month_id', $monthId)
            ->where('year', $year)
            ->get();

        $companySettings = CompanySetting::find(1);

        foreach ($billings as $billing) {
            $accountTitleData = $billing->charges()->get()->groupBy('account_title_id');
            $data = [
                'reference_no' => $billing->billing_no,
                'transaction_date' => $billing->billing_date,
                'contract_id' => $billing->contract_id,
                'client_id' => $billing->client_id,
                'total_amount' => $billing->amount,
            ];
            $accountTitles = [];

            $accountTitles[] = [
                'account_title_id' => $companySettings->ar_account_id,
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

        $closedBillingPeriod->created_by = Auth::id();
    }
}
