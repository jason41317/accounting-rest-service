<?php

namespace App\Models;

use App\Traits\SecureDelete;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractCharge extends Model
{
    use HasFactory, SoftDeletes, SecureDelete;

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
