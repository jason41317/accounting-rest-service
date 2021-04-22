<?php

namespace App\Models;

use App\Models\BaseModel;

class Billing extends BaseModel
{
    protected $guarded = ['id'];
    protected $appends = ['amount'];

    public function contract() {
        return $this->belongsTo(Contract::class);
    }

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function month() {
        return $this->belongsTo(Month::class);
    }

    public function charges() {
        return $this->belongsToMany(Charge::class,'billing_charges','billing_id','charge_id')
        ->withPivot('amount','notes');
    }

    public function adjustmentCharges() {
        return $this->belongsToMany(Charge::class, 'billing_adjustment_charges', 'billing_id', 'charge_id')
        ->withPivot('amount', 'notes');
    }

    public function getAmountAttribute() {
        $totalCharges = $this->charges()->sum('amount');
        $totalAdjustmentCharges = $this->adjustmentCharges()->sum('amount');
        return $totalCharges + $totalAdjustmentCharges;
    }
}
