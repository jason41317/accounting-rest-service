<?php

namespace App\Models;

use App\Models\BaseModel;


class Location extends BaseModel
{

    protected $guarded = ['id'];

    // for audit
    public $isAuditable = true;
    public function auditing()
    {
        $auditing = [];
        $auditing['alias'] = 'Location';
        $auditing['key'] = $this->name;
        return $auditing;
    }
    // end for audit

    public function rdo()
    {
        return $this->belongsTo(Rdo::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}
