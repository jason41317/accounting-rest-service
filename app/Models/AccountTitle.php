<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountTitle extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function accountClass()
    {
        return $this->belongsTo(AccountClass::class);
    }

    public function parentAccountTitle()
    {
        return $this->belongsTo(AccountTitle::class, 'parent_account_id');
    }
}
