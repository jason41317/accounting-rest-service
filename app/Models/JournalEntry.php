<?php

namespace App\Models;

use App\Models\BaseModel;

class JournalEntry extends BaseModel
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

    public function accountTitles() {
        return $this->belongsToMany(AccountTitle::class, 'journal_entry_account_titles', 'journal_entry_id', 'account_title_id')
            ->withPivot('debit', 'credit');
    }

    public function journalable()
    {
        return $this->morphTo();
    }
}
