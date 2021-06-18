<?php

namespace App\Models;

use App\Models\BaseModel;


class ServiceCategory extends BaseModel
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

    // for audit
    public $isAuditable = true;
    public function auditing()
    {
        $auditing = [];
        $auditing['alias'] = 'Service Category';
        $auditing['key'] = $this->name;
        return $auditing;
    }
    // end for audit

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
