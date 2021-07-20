<?php

namespace App\Models;

use App\Models\BaseModel;


class PermissionGroup extends BaseModel
{

    protected $guarded = ['id'];
    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at'
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class)
        ->orderBy('sort_key', 'ASC');
    }
}
