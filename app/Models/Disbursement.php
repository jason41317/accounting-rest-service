<?php

namespace App\Models;



class Disbursement extends BaseModel
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

    public function bank() {
        return $this->belongsTo(Bank::class);
    }

    public function disbursementStatus() {
        return $this->belongsTo(DisbursementStatus::class);
    }

    public function disbursementDetails() {
        return $this->hasMany(DisbursementDetail::class)->with('accountTitle');
    }

    public function summedAccountTitles() {
        return $this->hasMany(DisbursementDetail::class)
            ->groupBy('account_title_id')
            ->selectRaw('*, sum(amount) as debit, null as credit');
    }

    public function approvedByPersonnel() {
        return $this->belongsTo(Personnel::class, 'approved_by', 'id');
    }

    public function journalEntry()
    {
        return $this->morphOne(JournalEntry::class, 'journalable');
    }
}
