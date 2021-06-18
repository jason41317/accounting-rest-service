<?php

namespace App\Models;

use App\Models\BaseModel;

class Personnel extends BaseModel
{
    protected $appends = ['name'];
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
        $auditing['alias'] = 'Personnel';
        $auditing['key'] = $this->name;
        return $auditing;
    }
    // end for audit

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function getNameAttribute()
    {
        return ucFirst($this->first_name) . ' ' . ($this->middle_name ? ucFirst($this->middle_name) . ' ' : '') . ucFirst($this->last_name);
    }

    public function photo() {
        return $this->hasOne(PersonnelPhoto::class);
    }
}
