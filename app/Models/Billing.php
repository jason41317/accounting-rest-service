<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Billing extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

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
        return $this->hasMany(BillingCharge::class)->with('charge');
    }
    
    public function adjustmentCharges() {
        return $this->hasMany(BillingAdjustmentCharge::class)->with('charge');
    }

}
