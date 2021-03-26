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
}
