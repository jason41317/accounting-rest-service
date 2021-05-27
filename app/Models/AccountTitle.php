<?php

namespace App\Models;

use App\Models\BaseModel;
class AccountTitle extends BaseModel
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

    public function accountClass()
    {
        return $this->belongsTo(AccountClass::class);
    }

    public function parentAccountTitle()
    {
        return $this->belongsTo(AccountTitle::class, 'parent_account_id');
    }


    public function charges()
    {
        return $this->hasMany(Charge::class);
    }

    public function banks()
    {
        return $this->hasMany(Charge::class);
    }

    public function ewallets()
    {
        return $this->hasMany(Charge::class);
    }

    public function journalEntries()
    {
        return $this->belongsToMany(JournalEntry::class, 'journal_entry_account_titles', 'account_title_id', 'journal_entry_id')
        ->withPivot('debit', 'credit');
    }
}
