<?php

namespace App\Models;

use App\Models\BaseModel;



class Payment extends BaseModel
{

    protected $guarded = ['id'];
    // protected $appends = ['account_title'];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    // for audit
    public $isAuditable = true;
    public function auditing()
    {
        $auditing = [];
        $auditing['alias'] = 'Payment';
        $auditing['key'] = $this->payment_no . ' (' . $this->contract->contract_no . ' - ' . $this->client->name .')';
        $auditing['status_key'] = 'payment_status_id';
        $auditing['statuses'] = collect([['id' => 2, 'event' => 'Post']]); //status ids to check in observer
        return $auditing;
    }
    // end for audit

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

    public function ewallet()
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

    public function getRetainersFeeTotalAttribute() 
    {
        return $this->charges()->where('charge_category_id', 1)->get()->sum('pivot.amount');
    }

    public function getFilingTotalAttribute()
    {
        return $this->charges()->where('charge_category_id', 2)->get()->sum('pivot.amount');
    }

    public function getRemittanceTotalAttribute()
    {
        return $this->charges()->where('charge_category_id', 3)->get()->sum('pivot.amount');
    }

    public function getOthersTotalAttribute()
    {
        return $this->charges()->where('charge_category_id', 4)->get()->sum('pivot.amount');
    }

    public function getAccountTitleAttribute()
    {
        return $this->charges()->get()->groupBy('account_title_id');
    }

    public function journalEntry()
    {
        return $this->morphOne(JournalEntry::class, 'journalable');
    }
}
