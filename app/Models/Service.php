<?php

namespace App\Models;

use App\Models\BaseModel;


class Service extends BaseModel 
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
        $auditing['alias'] = 'Service';
        $auditing['key'] = $this->name;
        return $auditing;
    }
    // end for audit

    public function contracts() 
    {
        return $this->belongsToMany(Contract::class, 'contract_services', 'service_id', 'contract_id');
    }

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
