<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountTitle extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function accountClass()
    {
        return $this->belongsTo(AccountClass::class);
    }

    public function parentAccountTitle()
    {
        return $this->belongsTo(AccountTitle::class, 'parent_account_id');
    }
}
