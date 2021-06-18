<?php

namespace App\Models;

use App\Models\BaseModel;


class Rdo extends BaseModel
{
    protected $guarded = ['id'];

    // for audit
    public $isAuditable = true;
    public function auditing()
    {
        $auditing = [];
        $auditing['alias'] = 'RDO';
        $auditing['key'] = $this->name;
        return $auditing;
    }
    // end for audit

    public function locations()
    {
        return $this->hasMany(Location::class);
    }
}
