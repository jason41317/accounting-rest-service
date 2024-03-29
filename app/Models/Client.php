<?php

namespace App\Models;

use App\Models\BaseModel;

class Client extends BaseModel
{

    protected $guarded = ['id'];
    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $appends = ['current_balance'];

    // for audit
    public $isAuditable = true;
    public function auditing()
    {
        $auditing = [];
        $auditing['alias'] = 'Client';
        $auditing['key'] = $this->name .' ('.$this->trade_name.')';
        return $auditing;
    }
    // end for audit

    public function contracts() {
        return $this->hasMany(Contract::class);
    }


    public function billings()
    {
        return $this->hasMany(Billing::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getCurrentBalanceAttribute()
    {
        $billings = $this->billings()
            ->get()
            ->sum('amount');
        $payments = $this->payments()
            ->get()
            ->sum('amount');

        return $billings - $payments;
    }

    public function getAsOfBalanceAttribute()
    {
        return $this->attributes['as_of_balance'];
    }

    public function setAsOfBalanceAttribute($value)
    {
        $this->attributes['as_of_balance'] = $value;
    }

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
