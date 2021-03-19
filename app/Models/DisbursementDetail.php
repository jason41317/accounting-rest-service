<?php

namespace App\Models;

use App\Traits\SecureDelete;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DisbursementDetail extends Model
{
    use HasFactory, SoftDeletes, SecureDelete;

    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected $guarded = ['id'];

    public function accountTitle() {
        return $this->belongsTo(AccountTitle::class);
    }
}
