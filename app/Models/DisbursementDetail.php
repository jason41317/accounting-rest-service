<?php

namespace App\Models;


class DisbursementDetail extends BaseModel
{
    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $guarded = ['id'];

    public function accountTitle() {
        return $this->belongsTo(AccountTitle::class);
    }
}
