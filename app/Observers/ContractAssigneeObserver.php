<?php

namespace App\Observers;

use App\Models\ContractAssignee;

class ContractAssigneeObserver
{
    /**
     * Handle the Contract "created" event.
     *
     * @param  \App\Models\ContractAssignee  $contractAssignee
     * @return void
     */
    public function created(ContractAssignee $contractAssignee)
    {
        $contractAssignees = ContractAssignee::where('contract_id', $contractAssignee->contract_id)
            ->where('id', '!=', $contractAssignee->id);
        $contractAssignees->update([
            'is_active' => 0,
        ]);
    }
}
