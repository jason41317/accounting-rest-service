<?php

namespace App\Observers;

use App\Models\CompanySetting;
use Carbon\Carbon;
use App\Models\Payment;
use App\Models\JournalEntry;
use App\Services\JournalEntryService;
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
        $companySettings = CompanySetting::find(1);
        $approvedStatusId = 2;

        if($payment->payment_status_id === $approvedStatusId) {
            $payment->approved_by = Auth::id();
            $payment->approved_at = Carbon::now();

            //insert on journal entry
            $data = [
                'reference_no' => $payment->payment_no,
                'transaction_date' => $payment->transaction_date,
                'contract_id' => $payment->contract_id,
                'client_id' => $payment->client_id,
                'total_amount' => $payment->amount,
                'payment_type_id' => $payment->payment_type_id,
                'e_wallet_id' => $payment->e_wallet_id,
                'bank_id' => $payment->bank_id,
                'payment_reference_no' => $payment->reference_no,
                'payment_reference_date' => $payment->reference_date,
            ];

            $items = [];
            $accountTitles = $payment->charges()
                ->selectRaw('*')
                ->selectRaw('SUM(amount) as total_debit')->groupBy('account_title_id')->get();

            $items[] = [
                'account_title_id' => $companySettings->ar_account_id,
                'debit' => 0, 
                'credit' => $payment->amount
            ];

            foreach($accountTitles as $accountTitle) {
                $journalEntriesData[] =
                [
                    'account_title_id' => $accountTitle['account_title_id'],
                    'debit' => $accountTitle['total_debit'],
                    'credit' => 0
                ];
            }

            $journalEntryService = new JournalEntryService();
            $journalEntryService->store($data, $items);
        }

        $payment->updated_by = Auth::id();
    }
}
