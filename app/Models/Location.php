<?php

namespace App\Models;

use App\Models\BaseModel;


class Location extends BaseModel
{

    protected $guarded = ['id'];

    public function rdo()
    {
        return $this->belongsTo(Rdo::class);
    }
}
