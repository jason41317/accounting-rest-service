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
            $data = [
                'reference_no' => $disbursement->voucher_no,
                'transaction_date' => $disbursement->created_at,
                'total_amount' => $disbursement->cheque_amount,
                'bank_id' => $disbursement->bank_id,
                'payment_reference_no' => $disbursement->cheque_no,
                'payment_reference_date' => $disbursement->cheque_date,
            ];

            $items = [];
            $accountTitles = $disbursement->summedAccountTitles()->get();
            $bank = $disbursement->bank;

            foreach ($accountTitles as $accountTitle) {
                $items[] =
                    [
                        'account_title_id' => $accountTitle['account_title_id'],
                        'debit' => 0,
                        'credit' => $accountTitle['debit']
                    ];
            }

            $items[] = [
                'account_title_id' => $bank->account_title_id,
                'debit' => $disbursement->cheque_amount,
                'credit' => 0
            ];

            // $journalEntry->accountTitles()->sync($journalEntriesData);
            $journalEntryService = new JournalEntryService();
            $journalEntryService->store($data, $items);
        }
    }
}
