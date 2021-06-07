<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingPeriod extends BaseModel
{
    use HasFactory;
    protected $guarded = ['id'];

    public function month()
    {
        return $this->belongsTo(Month::class);
    }
}
