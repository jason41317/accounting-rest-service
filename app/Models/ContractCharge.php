<?php

namespace App\Models;

use App\Models\BaseModel;

class ContractCharge extends BaseModel
{

    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function schedules() {
        return $this->belongsToMany(Month::class, 'contract_charge_schedules', 'charge_id', 'month_id');
    }

    public function charge() {
        return $this->belongsTo(Charge::class);
    }

}
