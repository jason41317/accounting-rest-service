<?php

namespace App\Models;

use App\Models\BaseModel;

class BusinessStyle extends BaseModel
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
        $auditing['alias'] = 'Business Style';
        $auditing['key'] = $this->name;
        return $auditing;
    }
    // end for audit

    public function contracts() {
        return $this->hasMany(Contract::class);
    }
}
