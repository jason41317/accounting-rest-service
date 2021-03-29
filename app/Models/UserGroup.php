<?php

namespace App\Models;

use App\Models\BaseModel;

class UserGroup extends BaseModel
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

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_group_permissions', 'user_group_id', 'permission_id');
    }
}