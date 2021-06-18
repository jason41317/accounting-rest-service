<?php

namespace App\Observers;

use Carbon\Carbon;
use App\Models\Contract;
use Illuminate\Support\Facades\Auth;

class ContractObserver
{
    /**
     * Handle the Contract "creating" event.
     *
     * @param  \App\Models\Contract  $contract
     * @return void
     */
    public function creating(Contract $contract)
    {
        $count = Contract::count() + 1;
        $contract->contract_no = 'CN-' . date('Y') . '-' . str_pad($count, 6, '0', STR_PAD_LEFT);
    }
    /**
     * Handle the Contract "updating" event.
     *
     * @param  \App\Models\Contract  $contract
     * @return void
     */
    public function updating(Contract $contract)
    {
        $approvedStatusId = 2;

        if($contract->contract_status_id === $approvedStatusId) {
            $contract->approved_by = Auth::id();
            $contract->approved_at = Carbon::now();
        }

        $contract->updated_by = Auth::id();
    }
}
