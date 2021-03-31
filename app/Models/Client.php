<?php

namespace App\Models;

use App\Models\BaseModel;

class Client extends BaseModel
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

    public function contracts() {
        return $this->hasMany(Contract::class);
    }


    public function billings()
    {
        return $this->hasMany(Billing::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
