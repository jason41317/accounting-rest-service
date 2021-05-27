<?php

namespace App\Observers;

use Carbon\Carbon;
use App\Models\Payment;
use App\Models\JournalEntry;
use App\Models\SystemSetting;
use App\Models\CompanySetting;
use Illuminate\Support\Facades\Auth;
use App\Services\JournalEntryService;

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
        $systemSetting = SystemSetting::find(1);
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
                'ewallet_id' => $payment->ewallet_id,
                'bank_id' => $payment->bank_id,
                'payment_reference_no' => $payment->reference_no,
                'payment_reference_date' => $payment->reference_date,
            ];

            $items = [];
            // $accountTitles = $payment->charges()
            //     ->selectRaw('*')
            //     ->selectRaw('SUM(amount) as total_debit')->groupBy('account_title_id')->get();

            // $items[] = [
            //     'account_title_id' => $companySettings->ar_account_id,
            //     'debit' => 0,
            //     'credit' => $payment->amount
            // ];

            // foreach($accountTitles as $accountTitle) {
            //     $journalEntriesData[] =
            //     [
            //         'account_title_id' => $accountTitle['account_title_id'],
            //         'debit' => $accountTitle['total_debit'],
            //         'credit' => 0
            //     ];
            // }

            if ($payment->payment_type_id === 1) {
                //cash payment
                $items[] =
                [
                    'account_title_id' => $systemSetting->cash_account_title_id,
                    'debit' => $payment->amount,
                    'credit' => 0
                ];
            }
            elseif ($payment->payment_type_id === 2 || $payment->payment_type_id === 3) {
                //check and bank deposit
                $bank = $payment->bank;
                $items[] =
                [
                    'account_title_id' => $bank->account_title_id,
                    'debit' => $payment->amount,
                    'credit' => 0
                ];
            }
            elseif ($payment->payment_type_id === 4) {
                //eWallet
                $eWallet = $payment->ewallet;
                $items[] =
                [
                    'account_title_id' => $eWallet->account_title_id,
                    'debit' => $payment->amount,
                    'credit' => 0
                ];
            }

            $items[] =
            [
                'account_title_id' => $systemSetting->accounts_receivable_account_title_id,
                'debit' => 0,
                'credit' => $payment->amount
            ];

            $journalEntryService = new JournalEntryService();
            $journalEntryService->store($data, $items);
        }

        $payment->updated_by = Auth::id();
    }
}
