<?php

namespace App\Observers;

use App\Models\CreditMemo;

class CreditMemoObserver
{
    public function creating(CreditMemo $creditMemo) {
        $count = CreditMemo::count() + 1;
        $creditMemo->credit_memo_no = 'CM-' . date('Ym', strtotime($creditMemo['year'] . '-' . $creditMemo['month_id'] . '-1')) . '-' . str_pad($count, 6, '0', STR_PAD_LEFT);
    }
}
