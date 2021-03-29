<?php

namespace App\Models;

use App\Models\BaseModel;


class ContractFile extends BaseModel
{

    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function documentType() {
        return $this->belongsTo(DocumentType::class);
    }
}
