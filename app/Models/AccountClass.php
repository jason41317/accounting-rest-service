<?php

namespace App\Models;

use App\Models\BaseModel;

class AccountClass extends BaseModel
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

    // for audit
    public $isAuditable = true;
    public function auditing()
    {
        $auditing = [];
        $auditing['alias'] = 'Account Class';
        $auditing['key'] = $this->name;
        return $auditing;
    }
    // end for audit

    public function accountType()
    {
        return $this->belongsTo(AccountType::class);
    }

    public function accountTitles()
    {
        return $this->hasMany(AccountTitle::class);
    }
}
