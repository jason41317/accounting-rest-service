<?php

namespace App\Models;

use App\Traits\SecureDelete;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountClass extends Model
{
    use HasFactory, SoftDeletes, SecureDelete;

    protected $guarded = ['id'];
    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function accountType()
    {
        return $this->belongsTo(AccountType::class);
    }

    public function accountTitles()
    {
        return $this->hasMany(AccountTitle::class);
    }
}
