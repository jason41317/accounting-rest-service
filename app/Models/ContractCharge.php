<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractCharge extends Model
{
    use HasFactory;

    public function schedules() {
        return $this->belongsToMany(Month::class, 'contract_charge_schedules', 'contract_charge_id', 'month_id');
    }

    public function charge() {
        return $this->belongsTo(Charge::class);
    }

}
