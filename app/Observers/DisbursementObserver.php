<?php

namespace App\Observers;

use Carbon\Carbon;
use App\Models\Disbursement;
use App\Models\JournalEntry;
use App\Models\CompanySetting;
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

            //insert on journal entry
            $journalEntryData = [
                'reference_no' => $disbursement->voucher_no,
                'transaction_date' => $disbursement->created_at,
                'total_amount' => $disbursement->cheque_amount,
                'bank_id' => $disbursement->bank_id,
                'payment_reference_no' => $disbursement->cheque_no,
                'payment_reference_date' => $disbursement->cheque_date,
            ];

            $journalEntry = JournalEntry::create($journalEntryData);

            $journalEntriesData = [];
            $accountTitles = $disbursement->summedAccountTitles()->get();
            $bank = $disbursement->bank;

            foreach($accountTitles as $accountTitle) {
                $journalEntriesData[$accountTitle['account_title_id']] =
                [
                    'debit' => $accountTitle['debit'],
                    'credit' => 0
                ];
            }

            $journalEntriesData[$bank->account_title_id] = [ 'debit' => 0, 'credit' => $disbursement->cheque_amount];

            $journalEntry->accountTitles()->sync($journalEntriesData);
        }

        $disbursement->updated_by = Auth::id();
    }
}
