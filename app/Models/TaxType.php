<?php

namespace App\Models;

use App\Models\BaseModel;

class TaxType extends BaseModel
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

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}
