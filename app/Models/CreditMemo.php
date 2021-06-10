<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditMemo extends BaseModel
{
    protected $guarded = ['id'];
    protected $appends = ['amount'];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function month()
    {
        return $this->belongsTo(Month::class);
    }

    public function charges()
    {
        return $this->belongsToMany(Charge::class, 'credit_memo_charges', 'credit_memo_id', 'charge_id')
        ->withPivot('amount', 'notes');
    }

    public function getAmountAttribute()
    {
        $totalCharges = $this->charges()->sum('amount');
        return $totalCharges;
    }
}
