<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Charge extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function schedules() {
        return $this->belongsToMany(Month::class, 'contract_charge_schedules', 'contract_charge_id', 'month_id');
    }

    public function contracts() {
        return $this->belongsToMany(Contract::class, 'contract_charges', 'charge_id', 'contract_id');
    }

    public function accountTitle() {
        return $this->belongsTo(AccountTitle::class);
    }
}
