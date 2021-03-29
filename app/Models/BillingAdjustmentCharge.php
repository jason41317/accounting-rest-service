<?php

namespace App\Models;

use App\Models\BaseModel;

class BillingAdjustmentCharge extends BaseModel
{
    public function charge() {
        return $this->belongsTo(Charge::class);
    }
}
