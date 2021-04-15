<?php

namespace App\Models;

use App\Models\BaseModel;



class Payment extends BaseModel
{

    protected $guarded = ['id'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function charges()
    {
        return $this->belongsToMany(Charge::class, 'payment_charges', 'payment_id', 'charge_id')->withPivot('amount', 'for_deposit');
    }

    public function paymentStatus()
    {
        return $this->belongsTo(PaymentStatus::class);
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function eWallet()
    {
        return $this->belongsTo(Ewallet::class);
    }

    public function approvedByPersonnel() {
        return $this->belongsTo(Personnel::class, 'approved_by', 'id');
    }

    public function getForPaymentAmountAttribute() {
        return $this->charges()->wherePivot('for_deposit', 0)->get()->sum('pivot.amount');
    }

    public function getForDepositAmountAttribute() {
        return $this->charges()->wherePivot('for_deposit', 1)->get()->sum('pivot.amount');
    }
}
