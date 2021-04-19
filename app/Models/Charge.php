<?php

namespace App\Models;

use App\Models\BaseModel;

class Charge extends BaseModel
{
    protected $guarded = ['id'];
    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    // protected $appends = ['chargeSchedules'];

    public function schedules() {
        return $this->belongsToMany(Month::class, 'contract_charge_schedules', 'charge_id', 'month_id');
    }

    // public function getChargeSchedulesAttribute() {
    //     return $this->schedules()->wherePivot('contract_id', $this->pivot->contract_id)->get();
    // }

    public function contracts() {
        return $this->belongsToMany(Contract::class, 'contract_charges', 'charge_id', 'contract_id');
    }

    public function billings()
    {
        return $this->belongsToMany(Billing::class, 'billing_charges', 'charge_id', 'billing_id');
    }

    public function payments()
    {
        return $this->belongsToMany(Payment::class, 'payment_charges', 'charge_id', 'payment_id');
    }

    public function accountTitle() {
        return $this->belongsTo(AccountTitle::class);
    }

    public function chargeCategory()
    {
        return $this->belongsTo(ChargeCategory::class);
    }
}
