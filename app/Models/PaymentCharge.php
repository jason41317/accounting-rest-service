<?php

namespace App\Models;

use App\Models\BaseModel;

class PaymentCharge extends BaseModel
{
    public function payment() {
        return $this->belongsTo(Payment::class);
    }
}
