<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingPeriod extends BaseModel
{
    use HasFactory;
    protected $guarded = ['id'];

    // for audit
    public $isAuditable = true;
    public function auditing()
    {
        $auditing = [];
        $auditing['alias'] = 'Billing Period';
        $auditing['key'] = date('F Y', strtotime($this->year.'-'.$this->month_id.'-1'));
        return $auditing;
    }
    // end for audit

    public function month()
    {
        return $this->belongsTo(Month::class);
    }
}
