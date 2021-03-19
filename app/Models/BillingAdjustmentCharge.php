<?php

namespace App\Models;

use App\Traits\SecureDelete;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillingAdjustmentCharge extends Model
{
    use HasFactory, SoftDeletes, SecureDelete;

    public function charge() {
        return $this->belongsTo(Charge::class);
    }
}
