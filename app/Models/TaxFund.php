<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxFund extends BaseModel
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $appends = ['previous_balance', 'balance'];
    protected $with = ['createdByUser'];

    public function getPreviousBalanceAttribute()
    {
        $taxFunds = TaxFund::where('created_at', '<', $this->created_at)
            ->get();
        $debit = $taxFunds->sum('debit');
        $credit = $taxFunds->sum('credit');

        return $debit - $credit;
    }

    public function getBalanceAttribute()
    {
        return $this->getPreviousBalanceAttribute() + ($this->debit - $this->credit);
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by')
            ->with('userable');
    }
}
