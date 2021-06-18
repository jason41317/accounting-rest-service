<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanySetting extends BaseModel
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
        $auditing['alias'] = 'Company Setting';
        $auditing['key'] = '';
        return $auditing;
    }
    // end for audit

    protected $with = ['logo'];

    public function logo()
    {
        return $this->hasOne(CompanySettingLogo::class);
    }
}
