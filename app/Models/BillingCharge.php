<?php

namespace App\Models;

use App\Models\BaseModel;

class BillingCharge extends BaseModel
{
    public function charge() {
        return $this->belongsTo(Charge::class);
    }
}
