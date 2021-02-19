<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillingCharge extends Model
{
    use HasFactory, SoftDeletes;

    public function charge() {
        return $this->belongsTo(Charge::class);
    }
}
